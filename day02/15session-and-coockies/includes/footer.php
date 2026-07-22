    </main>
    <footer>
        <div class="footer-content">
            <p>&copy; <?= date('Y') ?> Система за вход - Всички права запазени</p>
            <p class="footer-info">
                <span>📅 <?= date('d.m.Y H:i:s') ?></span>
                <span>🔒 <?= session_status() === PHP_SESSION_ACTIVE ? 'Активна сесия' : 'Няма активна сесия' ?></span>
            </p>
        </div>
    </footer>
</body>
</html>