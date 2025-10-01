/**
 * Framework Navigation Script
 * Универсална система за управление на активните табове в навигацията
 * 
 * Как работи:
 * - Автоматично маркира активния таб на базата на текущия URL
 * - Работи с всякакви имена на навигационни елементи
 * - Използва интелигентен алгоритъм за съвпадение на URL-и
 * - Поддържа групиране и persistence на табове
 * 
 * Поддържани data атрибути:
 * - data-nav-group: Групира навигационни елементи (по подразбиране: '.navbar-nav')
 * - data-nav-persist: Запазва активния таб в localStorage (стойност: 'true')
 * 
 * Примери за използване:
 * 
 * Основна навигация:
 * <nav class="navbar">
 *   <ul class="navbar-nav">
 *     <li><a class="nav-link" href="/home">Начало</a></li>
 *     <li><a class="nav-link" href="/products">Продукти</a></li>
 *     <li><a class="nav-link" href="/about">За нас</a></li>
 *   </ul>
 * </nav>
 * 
 * С персонализирано групиране:
 * <div class="sidebar-nav">
 *   <a class="nav-link" href="/admin/users" data-nav-group=".sidebar-nav">Потребители</a>
 *   <a class="nav-link" href="/admin/settings" data-nav-group=".sidebar-nav">Настройки</a>
 * </div>
 * 
 * С persistence:
 * <a class="nav-link" href="/dashboard" data-nav-persist="true">Табло</a>
 */

class NavigationManager {
    constructor() {
        this.init();
    }

    init() {
        this.setActiveTab();
        this.bindEvents();
    }

    /**
     * Маркира активния таб на базата на текущия URL
     */
    setActiveTab() {
        const currentPath = this.normalizeUrl(window.location.pathname);
        const navLinks = document.querySelectorAll('.navbar-nav .nav-link[href]');
        
        let bestMatch = null;
        let bestMatchScore = 0;
        
        navLinks.forEach(link => {
            // Премахни active класа от всички линкове
            link.classList.remove('active');
            
            const href = link.getAttribute('href');
            if (href) {
                const score = this.calculateMatchScore(currentPath, href);
                if (score > bestMatchScore) {
                    bestMatchScore = score;
                    bestMatch = link;
                }
            }
        });
        
        // Маркирай най-добрия match като активен
        if (bestMatch && bestMatchScore > 0) {
            bestMatch.classList.add('active');
        }
    }

    /**
     * Нормализира URL за сравнение
     */
    normalizeUrl(url) {
        // Премахни query parameters и trailing slash
        return url.split('?')[0].replace(/\/$/, '') || '/';
    }

    /**
     * Изчислява score за съвпадение между текущия път и navigation link
     */
    calculateMatchScore(currentPath, linkHref) {
        try {
            const linkPath = this.normalizeUrl(new URL(linkHref, window.location.origin).pathname);
            
            // Точно съвпадение - най-висок score
            if (currentPath === linkPath) {
                return 100;
            }
            
            // Начална страница - специален случай
            if ((currentPath === '/' || currentPath === '') && 
                (linkPath === '/' || linkPath === '')) {
                return 100;
            }
            
            // Частично съвпадение - колкото повече сегменти съвпадат, толкова по-висок score
            const currentSegments = currentPath.split('/').filter(s => s.length > 0);
            const linkSegments = linkPath.split('/').filter(s => s.length > 0);
            
            if (currentSegments.length === 0 || linkSegments.length === 0) {
                return 0;
            }
            
            let matchingSegments = 0;
            const minLength = Math.min(currentSegments.length, linkSegments.length);
            
            for (let i = 0; i < minLength; i++) {
                if (currentSegments[i] === linkSegments[i]) {
                    matchingSegments++;
                } else {
                    break; // Спри при първо несъвпадение
                }
            }
            
            // Score на базата на процент съвпадащи сегменти
            if (matchingSegments > 0) {
                // Дай предимство на по-дългите съвпадения
                return (matchingSegments / Math.max(currentSegments.length, linkSegments.length)) * 50 + 
                       (matchingSegments * 10);
            }
            
            return 0;
        } catch (e) {
            console.warn('Error calculating match score:', e);
            return 0;
        }
    }

    /**
     * Добавя event listeners
     */
    bindEvents() {
        // При натискане на nav link, маркирай като активен
        document.addEventListener('click', (e) => {
            if (e.target.classList.contains('nav-link') && e.target.getAttribute('href')) {
                // Проверява дали има data-nav-group за групиране
                const navGroup = e.target.getAttribute('data-nav-group') || '.navbar-nav';
                
                // Премахни active от всички в същата група
                document.querySelectorAll(`${navGroup} .nav-link`).forEach(link => {
                    link.classList.remove('active');
                });
                
                // Добави active на натиснатия
                e.target.classList.add('active');
                
                // Запази активния таб в localStorage за persistence
                if (e.target.getAttribute('data-nav-persist') === 'true') {
                    localStorage.setItem('activeNavTab', e.target.getAttribute('href'));
                }
            }
        });
        
        // Възстанови активния таб от localStorage
        this.restoreActiveTab();
    }
    
    /**
     * Възстановява активния таб от localStorage
     */
    restoreActiveTab() {
        const savedActiveTab = localStorage.getItem('activeNavTab');
        if (savedActiveTab) {
            const savedLink = document.querySelector(`.nav-link[href="${savedActiveTab}"][data-nav-persist="true"]`);
            if (savedLink && this.calculateMatchScore(this.normalizeUrl(window.location.pathname), savedActiveTab) > 0) {
                // Само ако текущата страница наистина съвпада със запазения таб
                return; // setActiveTab() ще се погрижи за маркирането
            }
        }
    }
}