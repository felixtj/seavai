<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Seav.ai - The Candidate-First Job Marketplace')</title>
    <meta name="description" content="@yield('description', 'Stop searching, start getting matched. Seav.ai is the modern job marketplace designed for candidates, not advertisers.')">
    <link rel="stylesheet" href="{{ asset('css/style_candidate.css') }}">
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body>

    @yield('content')

    <script>
        lucide.createIcons();

        const navbar = document.getElementById('navbar');
        if (navbar) {
            window.addEventListener('scroll', () => {
                navbar.classList.toggle('scrolled', window.scrollY > 50);
            });
        }

        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    e.preventDefault();
                    target.scrollIntoView({ behavior: 'smooth' });
                }
            });
        });
    </script>
</body>
</html>
