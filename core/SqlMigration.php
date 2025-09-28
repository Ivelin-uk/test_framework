<?php

namespace Core;

/**
 * SQL Migration клас за управление на база данни миграции
 * 
 * Този клас отговаря за изпълнение на SQL файлове и управление на миграции.
 */
class SqlMigration
{
    private $pdo;
    private $config;
    
    /**
     * Конструктор
     * 
     * @param array $config Конфигурация за база данни
     */
    public function __construct($config = null)
    {
        $this->config = $config ?? require CONFIG_PATH . '/database.php';
        $this->connect();
        $this->createMigrationsTable();
    }
    
    /**
     * Свързване към базата данни
     */
    private function connect()
    {
        $dsn = "mysql:host={$this->config['host']};port={$this->config['port']};charset={$this->config['charset']}";
        
        try {
            $this->pdo = new \PDO($dsn, $this->config['username'], $this->config['password'], [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            ]);
            
            // Създаване на базата данни ако не съществува
            $this->pdo->exec("CREATE DATABASE IF NOT EXISTS `{$this->config['database']}`");
            $this->pdo->exec("USE `{$this->config['database']}`");
            
        } catch (\PDOException $e) {
            throw new \Exception("Грешка при свързване с базата данни: " . $e->getMessage());
        }
    }
    
    /**
     * Създава таблица за следене на миграциите
     */
    private function createMigrationsTable()
    {
        $sql = "CREATE TABLE IF NOT EXISTS migrations (
            id INT AUTO_INCREMENT PRIMARY KEY,
            filename VARCHAR(255) NOT NULL,
            executed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            UNIQUE KEY unique_filename (filename)
        )";
        
        $this->pdo->exec($sql);
    }
    
    /**
     * Изпълнява всички SQL файлове от дадена директория
     * 
     * @param string $directory Път към директорията с SQL файлове
     * @return array Резултат от изпълнението
     */
    public function runSqlFiles($directory)
    {
        if (!is_dir($directory)) {
            throw new \Exception("Директорията {$directory} не съществува");
        }
        
        $files = glob($directory . '/*.sql');
        sort($files); // Подредба по име за правилен ред на изпълнение
        
        $results = [];
        
        foreach ($files as $file) {
            $filename = basename($file);
            
            // Проверка дали файлът е вече изпълнен
            if ($this->isMigrationExecuted($filename)) {
                $results[] = [
                    'file' => $filename,
                    'status' => 'skipped',
                    'message' => 'Вече изпълнен'
                ];
                continue;
            }
            
            try {
                $this->executeSqlFile($file);
                $this->markMigrationAsExecuted($filename);
                
                $results[] = [
                    'file' => $filename,
                    'status' => 'success',
                    'message' => 'Успешно изпълнен'
                ];
                
            } catch (\Exception $e) {
                $results[] = [
                    'file' => $filename,
                    'status' => 'error',
                    'message' => $e->getMessage()
                ];
            }
        }
        
        return $results;
    }
    
    /**
     * Изпълнява SQL файл
     * 
     * @param string $filePath Път към SQL файла
     */
    private function executeSqlFile($filePath)
    {
        $sql = file_get_contents($filePath);
        
        if ($sql === false) {
            throw new \Exception("Не може да се прочете файлът: {$filePath}");
        }
        
        // Разделяне на заявките по точка и запетая
        $statements = array_filter(array_map('trim', explode(';', $sql)));
        
        foreach ($statements as $statement) {
            if (!empty($statement)) {
                $this->pdo->exec($statement);
            }
        }
    }
    
    /**
     * Проверява дали миграцията е изпълнена
     * 
     * @param string $filename Име на файла
     * @return bool
     */
    private function isMigrationExecuted($filename)
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM migrations WHERE filename = ?");
        $stmt->execute([$filename]);
        return $stmt->fetchColumn() > 0;
    }
    
    /**
     * Отбелязва миграцията като изпълнена
     * 
     * @param string $filename Име на файла
     */
    private function markMigrationAsExecuted($filename)
    {
        $stmt = $this->pdo->prepare("INSERT INTO migrations (filename) VALUES (?)");
        $stmt->execute([$filename]);
    }
    
    /**
     * Получава списък с изпълнени миграции
     * 
     * @return array
     */
    public function getExecutedMigrations()
    {
        $stmt = $this->pdo->query("SELECT * FROM migrations ORDER BY executed_at DESC");
        return $stmt->fetchAll();
    }
    
    /**
     * Изпълнява таблиците и данните
     */
    public function runAll()
    {
        echo "🚀 Започвам миграция на базата данни...\n\n";
        
        // Първо изпълняваме таблиците
        echo "📋 Създаване на таблици...\n";
        $tableResults = $this->runSqlFiles(BASE_PATH . '/sql/tables');
        $this->printResults($tableResults);
        
        // След това вмъкваме данните
        echo "\n📊 Вмъкване на данни...\n";
        $dataResults = $this->runSqlFiles(BASE_PATH . '/sql/data');
        $this->printResults($dataResults);
        
        echo "\n✅ Миграцията завърши успешно!\n";
    }
    
    /**
     * Отпечатва резултатите от миграцията
     * 
     * @param array $results
     */
    private function printResults($results)
    {
        foreach ($results as $result) {
            $icon = match($result['status']) {
                'success' => '✅',
                'skipped' => '⏭️',
                'error' => '❌',
                default => '❓'
            };
            
            echo "{$icon} {$result['file']} - {$result['message']}\n";
        }
    }
}