<header style="background: #2c3e50; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; color: white;">
    <div style="font-size: 20px; font-weight: bold;">
        <span style="color: #e74c3c;">★</span> МойСайт
    </div>
    <nav style="display: flex; gap: 20px; align-items: center;">
        <a href="{{ route('posts.index') }}" style="color: white; text-decoration: none; font-weight: bold;">Посты</a>
        <a href="{{ route('form.show') }}" style="color: white; text-decoration: none; font-weight: bold;">Форма</a>
        <a href="{{ route('submissions.index') }}" style="color: white; text-decoration: none; font-weight: bold;">Таблица заявок</a>
        <a href="/api/posts" target="_blank" style="color: #f1c40f; text-decoration: none; font-size: 13px;">API</a>
    </nav>
</header>
