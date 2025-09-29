<?php
// Нормализиране на $user (може да дойде като масив или обект)
$u = $user ?? null;
if (is_array($u)) {
		$u = (object)$u;
}

// Изчисляване на показвано име по новата схема
$first = $u->first_name ?? '';
$last  = $u->last_name ?? '';
$display = trim($first . ' ' . $last);
if ($display === '' && isset($u)) {
		$display = $u->username ?? ($u->email ?? ('#' . ($u->id ?? '')));
}
?>

<h1>Профил на потребител<?= isset($display) && $display !== '' ? ': ' . htmlspecialchars($display, ENT_QUOTES, 'UTF-8') : '' ?></h1>

<?php if (!$u): ?>
	<div>Потребителят не е намерен.</div>
<?php else: ?>
	<ul>
		<li><strong>ID:</strong> <?= (int)($u->id ?? 0) ?></li>
		<li><strong>Username:</strong> <?= htmlspecialchars($u->username ?? '', ENT_QUOTES, 'UTF-8') ?></li>
		<li><strong>Име:</strong> <?= htmlspecialchars(trim(($u->first_name ?? '') . ' ' . ($u->last_name ?? '')), ENT_QUOTES, 'UTF-8') ?></li>
		<li><strong>Email:</strong> <?= htmlspecialchars($u->email ?? '', ENT_QUOTES, 'UTF-8') ?></li>
		<li><strong>Статус:</strong> <?= !empty($u->is_active) ? 'Активен' : 'Неактивен' ?></li>
	</ul>
<?php endif; ?>