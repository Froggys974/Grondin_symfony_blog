// public/js/app.js
document.addEventListener('DOMContentLoaded', function() {
    const loading = document.getElementById('loading');
    const articleList = document.getElementById('article-list');

    if (loading && articleList) {
        loading.style.display = 'block';
        articleList.style.display = 'none';

        window.addEventListener('load', function() {
            loading.style.display = 'none';
            articleList.style.display = 'block';
        });
    }
});
