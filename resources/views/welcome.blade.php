<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="helo and welcome.">
    <title>taste matcha like never before.</title>

    <!-- Stylesheet -->
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
</head>
<body>

    <!-- Ambient glowing backgrounds -->
    <div class="ambient-bg">
        <div class="ambient-glow-1"></div>
        <div class="ambient-glow-2"></div>
    </div>

    <!-- Centered Teaser Container -->
    <div class="teaser-container">
        <div class="teaser-content">
            <h1 class="teaser-text">taste matcha like never before.</h1>
            
            <!-- Countdown timer block -->
            <div class="countdown-wrapper">
                <span class="countdown-label">COMING SOON</span>
                <div id="countdown-timer" class="countdown-timer">
                    <div class="countdown-item">
                        <span class="countdown-value" id="days">00</span>
                        <span class="countdown-unit">Days</span>
                    </div>
                    <div class="countdown-item">
                        <span class="countdown-value" id="hours">00</span>
                        <span class="countdown-unit">Hours</span>
                    </div>
                    <div class="countdown-item">
                        <span class="countdown-value" id="minutes">00</span>
                        <span class="countdown-unit">Mins</span>
                    </div>
                    <div class="countdown-item">
                        <span class="countdown-value" id="seconds">00</span>
                        <span class="countdown-unit">Secs</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Live Ticking Countdown Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const targetDate = new Date('2026-10-10T00:00:00').getTime();

            function updateCountdown() {
                const now = new Date().getTime();
                const distance = targetDate - now;

                if (distance < 0) {
                    document.getElementById('countdown-timer').innerHTML = '<span class="countdown-ended">Launch Date Reached</span>';
                    return;
                }

                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                document.getElementById('days').textContent = String(days).padStart(2, '0');
                document.getElementById('hours').textContent = String(hours).padStart(2, '0');
                document.getElementById('minutes').textContent = String(minutes).padStart(2, '0');
                document.getElementById('seconds').textContent = String(seconds).padStart(2, '0');
            }

            setInterval(updateCountdown, 1000);
            updateCountdown();
        });
    </script>

</body>
</html>
