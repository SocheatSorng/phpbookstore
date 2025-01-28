<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Book Not Found</title>
    <style>
        body {
            margin: 0;
            background: linear-gradient(45deg, #3498db, #2ecc71);
            overflow: hidden;
        }

        .error-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            position: relative;
        }

        .book {
            position: relative;
            width: 200px;
            height: 280px;
            transform-style: preserve-3d;
            transform: rotateX(10deg);
            animation: bounce 2s ease-in-out infinite;
        }

        .book-cover {
            position: absolute;
            width: 200px;
            height: 280px;
            transform-style: preserve-3d;
            background: #ff6b6b;
            border-radius: 20px 40px 40px 20px;
            box-shadow: 
                inset 3px 0px 20px rgba(0, 0, 0, 0.1),
                0 8px 15px rgba(0, 0, 0, 0.2);
            border: 4px solid #444;
            transform-origin: 0 50%;
            z-index: 100;
        }

        .book-cover::after {
            content: "404";
            position: absolute;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 60px;
            font-family: 'Comic Sans MS', cursive;
            color: #fff;
            text-shadow: 3px 3px 0 #000;
        }

        .book-spine {
            position: absolute;
            left: 0;
            width: 40px;
            height: 280px;
            transform-origin: 0 50%;
            transform: rotateY(90deg) translateX(-20px);
            background: #ff8787;
            border-radius: 10px 0 0 10px;
            border: 4px solid #444;
            box-shadow: inset -2px 0 5px rgba(0,0,0,0.2);
        }

        .page {
            position: absolute;
            width: 190px;
            height: 270px;
            top: 5px;
            left: 5px;
            background: #fff;
            border-radius: 0 15px 15px 0;
            transform-style: preserve-3d;
            transform-origin: 0 50%;
            z-index: 99;
            border: 2px solid #ddd;
        }

        .page::before {
            content: '';
            position: absolute;
            left: -1px;
            width: 2px;
            height: 100%;
            background: linear-gradient(90deg, #ddd, #bbb);
        }

        .page-content {
            padding: 20px;
            font-family: 'Times New Roman', serif;
            font-size: 12px;
            color: #333;
            line-height: 1.4;
            background-image: 
                linear-gradient(#999 0.05em, transparent 0.05em);
            background-size: 100% 1.4em;
        }

        .page:nth-child(2) { transform: rotateY(-28deg); }
        .page:nth-child(3) { transform: rotateY(-26deg); }
        .page:nth-child(4) { transform: rotateY(-24deg); }
        .page:nth-child(5) { transform: rotateY(-22deg); }

        @keyframes bounce {
            0%, 100% { 
                transform: rotateX(10deg) translateY(0); 
            }
            50% { 
                transform: rotateX(10deg) translateY(-20px); 
            }
        }

        .page-edge {
            position: absolute;
            right: 0;
            width: 30px;
            height: 100%;
            background: #fff;
            transform: rotateY(90deg) translateZ(15px);
            background-image: 
                repeating-linear-gradient(
                    to bottom,
                    #f0f0f0,
                    #f0f0f0 2px,
                    #fff 2px,
                    #fff 4px
                );
        }

        .particles {
            position: absolute;
            width: 100%;
            height: 100%;
        }

        .particle {
            position: absolute;
            background: rgba(255,255,255,0.5);
            border-radius: 50%;
            pointer-events: none;
        }

        .error-text {
            margin-top: 3rem;
            text-align: center;
            font-family: 'Arial', sans-serif;
            color: white;
            text-shadow: 0 2px 10px rgba(0,0,0,0.3);
        }

        .error-text h1 {
            font-size: 2.5em;
            margin-bottom: 0.5em;
            animation: glow 2s ease-in-out infinite alternate;
        }

        @keyframes glow {
            from { text-shadow: 0 0 5px #fff, 0 0 10px #fff, 0 0 15px #0073e6; }
            to { text-shadow: 0 0 10px #fff, 0 0 20px #fff, 0 0 30px #0073e6; }
        }

        .back-button {
            margin-top: 2rem;
            padding: 12px 30px;
            background: linear-gradient(45deg, #0073e6, #00c6ff);
            color: white;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            text-decoration: none;
            font-weight: bold;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .back-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.3);
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div id="particles" class="particles"></div>
        <div class="book">
            <div class="book-spine"></div>
            <div class="book-cover"></div>
            <div class="page">
                <div class="page-content">
                    Chapter 404: The Missing Page
                    
                    Once upon a time, in a digital library far away...
                </div>
            </div>
            <div class="page"></div>
            <div class="page"></div>
            <div class="page"></div>
            <div class="page"></div>
        </div>
        <div class="error-text">
            <h1>404 - Book Not Found</h1>
            <p>Sorry, this book seems to have vanished into thin air...</p>
        </div>
        <a href="/" class="back-button">Return to Library</a>
    </div>
    <script>
        function createParticles() {
            const container = document.getElementById('particles');
            for(let i = 0; i < 50; i++) {
                const particle = document.createElement('div');
                particle.className = 'particle';
                particle.style.width = Math.random() * 4 + 'px';
                particle.style.height = particle.style.width;
                particle.style.left = Math.random() * 100 + '%';
                particle.style.top = Math.random() * 100 + '%';
                particle.style.animation = `float ${Math.random() * 6 + 3}s linear infinite`;
                container.appendChild(particle);
            }
        }
        createParticles();
    </script>
</body>
</html>