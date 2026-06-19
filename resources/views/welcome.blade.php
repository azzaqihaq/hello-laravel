<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="helo and welcome.">
    <title>taste matcha like never before.</title>

    <!-- Three.js and OrbitControls -->
    <script src="https://cdn.jsdelivr.net/npm/three@0.128.0/build/three.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/controls/OrbitControls.js"></script>

    <!-- Stylesheet -->
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
</head>
<body>

    <!-- Ambient glowing backgrounds -->
    <div class="ambient-bg">
        <div class="ambient-glow-1"></div>
        <div class="ambient-glow-2"></div>
    </div>

    <!-- Responsive Layout Container -->
    <div class="teaser-container">
        <div class="landing-grid">
            
            <!-- Left Panel: Text & Countdown -->
            <div class="landing-left">
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

            <!-- Right Panel: Draggable 3D Canvas -->
            <div class="landing-right">
                <div class="matcha-3d-wrapper">
                    <!-- Instruction Hint to drag -->
                    <div class="drag-hint">
                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 12a9 9 0 0 1-9 9m9-9a9 9 0 0 0-9-9m9 9H3m9 9a9 9 0 0 1-9-9m9 9a9 9 0 0 0-9-9m9 9V3"></path>
                        </svg>
                        <span>Drag to rotate</span>
                    </div>
                    <div id="matcha-3d-container"></div>
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

    <!-- Three.js Draggable 3D Matcha Cup Render Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('matcha-3d-container');
            if (!container) return;

            const width = container.clientWidth;
            const height = container.clientHeight;

            // 1. Setup Scene
            const scene = new THREE.Scene();

            // 2. Setup Camera
            const camera = new THREE.PerspectiveCamera(40, width / height, 0.1, 100);
            camera.position.set(0, 1.2, 7.5);

            // 3. Setup WebGL Renderer with Studio Settings
            const renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true, powerPreference: "high-performance" });
            renderer.setSize(width, height);
            renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
            renderer.shadowMap.enabled = true;
            renderer.shadowMap.type = THREE.PCFSoftShadowMap;
            renderer.toneMapping = THREE.ACESFilmicToneMapping;
            renderer.toneMappingExposure = 1.15; // Balanced exposure to prevent washouts
            container.appendChild(renderer.domElement);

            // 4. Setup OrbitControls (drag to rotate camera viewpoint)
            const controls = new THREE.OrbitControls(camera, renderer.domElement);
            controls.enableZoom = false;
            controls.enablePan = false;
            controls.enableDamping = true;
            controls.dampingFactor = 0.05;
            controls.autoRotate = false; // We self-rotate the cup group instead for realistic reflections
            controls.maxPolarAngle = Math.PI / 2 + 0.05; // lock looking from below floor
            controls.minPolarAngle = Math.PI / 6;

            // 5. Upgraded Studio Environment Map (Three-point softbox reflections)
            function createStudioEnvMap() {
                const canvas = document.createElement('canvas');
                canvas.width = 1024;
                canvas.height = 512;
                const ctx = canvas.getContext('2d');
                
                // Very dark backdrop
                const bgGrad = ctx.createLinearGradient(0, 0, 0, 512);
                bgGrad.addColorStop(0, '#0a0c0e');
                bgGrad.addColorStop(1, '#030405');
                ctx.fillStyle = bgGrad;
                ctx.fillRect(0, 0, 1024, 512);
                
                // Light Source 1: Key White Studio Softbox (Left)
                const whiteSoftbox = ctx.createLinearGradient(120, 0, 320, 0);
                whiteSoftbox.addColorStop(0, 'rgba(255,255,255,0)');
                whiteSoftbox.addColorStop(0.5, 'rgba(255,255,255,0.98)');
                whiteSoftbox.addColorStop(1, 'rgba(255,255,255,0)');
                ctx.fillStyle = whiteSoftbox;
                ctx.fillRect(120, 30, 200, 452);
                
                // Light Source 2: Warm Golden Highlight (Right)
                const goldenSoftbox = ctx.createLinearGradient(680, 0, 880, 0);
                goldenSoftbox.addColorStop(0, 'rgba(253,224,71,0)');
                goldenSoftbox.addColorStop(0.5, 'rgba(253,224,71,0.65)');
                goldenSoftbox.addColorStop(1, 'rgba(253,224,71,0)');
                ctx.fillStyle = goldenSoftbox;
                ctx.fillRect(680, 80, 200, 352);
                
                // Light Source 3: Cool Rim Light (Top)
                const cyanSoftbox = ctx.createLinearGradient(0, 30, 0, 180);
                cyanSoftbox.addColorStop(0, 'rgba(6,182,212,0.6)');
                cyanSoftbox.addColorStop(1, 'rgba(6,182,212,0)');
                ctx.fillStyle = cyanSoftbox;
                ctx.fillRect(0, 0, 1024, 180);

                // Small crisp specular highlights
                ctx.fillStyle = 'rgba(255,255,255,0.5)';
                ctx.beginPath();
                ctx.arc(480, 120, 35, 0, Math.PI * 2);
                ctx.fill();
                
                const texture = new THREE.CanvasTexture(canvas);
                texture.mapping = THREE.EquirectangularReflectionMapping;
                return texture;
            }
            const envMap = createStudioEnvMap();
            scene.environment = envMap;

            // 6. Lights System (Key, Fill, and Rim lights)
            const ambientLight = new THREE.AmbientLight(0xffffff, 0.45); // Lower ambient to preserve detail
            scene.add(ambientLight);

            const dirLight = new THREE.DirectionalLight(0xffffff, 1.8); // Moderate key light
            dirLight.position.set(5, 8, 4);
            dirLight.castShadow = true;
            dirLight.shadow.mapSize.width = 2048;
            dirLight.shadow.mapSize.height = 2048;
            dirLight.shadow.camera.near = 0.5;
            dirLight.shadow.camera.far = 15;
            dirLight.shadow.camera.left = -2.5;
            dirLight.shadow.camera.right = 2.5;
            dirLight.shadow.camera.top = 2.5;
            dirLight.shadow.camera.bottom = -2.5;
            dirLight.shadow.bias = -0.0004;
            scene.add(dirLight);

            const rimLight = new THREE.DirectionalLight(0xffffff, 2.0); // Rich rim reflection
            rimLight.position.set(-4, 4, -4);
            scene.add(rimLight);

            const fillLight = new THREE.DirectionalLight(0x06b6d4, 0.8); // Soft cyan fill
            fillLight.position.set(-3, 0.5, 3);
            scene.add(fillLight);

            // 7. Floor Shadow Plane
            const floorGeo = new THREE.PlaneGeometry(30, 30);
            const floorMat = new THREE.ShadowMaterial({ opacity: 0.32 });
            const floor = new THREE.Mesh(floorGeo, floorMat);
            floor.rotation.x = -Math.PI / 2;
            floor.position.y = -2.05;
            floor.receiveShadow = true;
            scene.add(floor);

            // 8. Create cup group
            const cupGroup = new THREE.Group();
            scene.add(cupGroup);

            // Interpolation helper to get outer glass radius at a given height (y)
            function getGlassOuterRadius(y) {
                if (y < -1.75) return 1.12;
                if (y > 1.8) return 1.40;
                
                if (y >= -1.75 && y < -1.0) {
                    const t = (y - (-1.75)) / 0.75;
                    return 1.12 * (1 - t) + 1.15 * t;
                } else if (y >= -1.0 && y < 0.0) {
                    const t = (y - (-1.0)) / 1.0;
                    return 1.15 * (1 - t) + 1.22 * t;
                } else if (y >= 0.0 && y < 1.0) {
                    const t = y / 1.0;
                    return 1.22 * (1 - t) + 1.30 * t;
                } else {
                    const t = (y - 1.0) / 0.8;
                    return 1.30 * (1 - t) + 1.40 * t;
                }
            }

            // A. Glass Lathe Profile (Watertight Double-walled Geometry)
            const glassPoints = [];
            glassPoints.push(new THREE.Vector2(0, -1.9)); // Outer bottom center
            glassPoints.push(new THREE.Vector2(0.9, -1.9)); // Outer bottom corner start
            glassPoints.push(new THREE.Vector2(1.05, -1.85));
            glassPoints.push(new THREE.Vector2(1.12, -1.75));
            glassPoints.push(new THREE.Vector2(1.15, -1.0)); // Outer wall
            glassPoints.push(new THREE.Vector2(1.22, 0.0));
            glassPoints.push(new THREE.Vector2(1.30, 1.0));
            glassPoints.push(new THREE.Vector2(1.40, 1.8)); // Outer rim edge
            
            // Rounded Lip at top rim
            glassPoints.push(new THREE.Vector2(1.38, 1.83));
            glassPoints.push(new THREE.Vector2(1.34, 1.84));
            glassPoints.push(new THREE.Vector2(1.30, 1.81));
            
            // Inner Wall going down
            glassPoints.push(new THREE.Vector2(1.21, 1.0));
            glassPoints.push(new THREE.Vector2(1.13, 0.0));
            glassPoints.push(new THREE.Vector2(1.05, -1.0));
            glassPoints.push(new THREE.Vector2(0.98, -1.5)); // Heavy bottom start
            glassPoints.push(new THREE.Vector2(0.85, -1.55)); // Inner bottom corner
            glassPoints.push(new THREE.Vector2(0, -1.55)); // Inner bottom center

            const glassGeo = new THREE.LatheGeometry(glassPoints, 64);
            const glassMaterial = new THREE.MeshPhysicalMaterial({
                color: 0xffffff,
                transparent: true,
                opacity: 0.06,
                roughness: 0.01,
                metalness: 0.05,
                transmission: 0.99,
                ior: 1.52,
                thickness: 0.12,
                clearcoat: 1.0,
                clearcoatRoughness: 0.01,
                side: THREE.DoubleSide,
                depthWrite: true,
                envMapIntensity: 2.5
            });
            const glassMesh = new THREE.Mesh(glassGeo, glassMaterial);
            glassMesh.castShadow = true;
            glassMesh.receiveShadow = true;
            cupGroup.add(glassMesh);

            // B. Marbled Matcha Latte Liquid (Creamy opaque latte texture map)
            function createMarbledTexture() {
                const canvas = document.createElement('canvas');
                canvas.width = 512;
                canvas.height = 1024;
                const ctx = canvas.getContext('2d');
                
                // Base warm cream milk color
                ctx.fillStyle = '#faf6ee';
                ctx.fillRect(0, 0, 512, 1024);
                
                // Set heavy blur for organic marbling
                try {
                    ctx.filter = 'blur(28px)';
                } catch(e) {}
                
                // Draw swirly matcha concentrate bands (thick curved lines)
                const greenColors = ['#2b4718', '#385c21', '#4b7530', '#629344'];
                
                // We will draw several swirly green lines going from top to bottom
                for (let i = 0; i < 8; i++) {
                    ctx.strokeStyle = greenColors[i % greenColors.length];
                    ctx.lineWidth = 70 + Math.random() * 60;
                    ctx.lineCap = 'round';
                    
                    const startX = Math.random() * 512;
                    const cp1X = Math.random() * 512;
                    const cp1Y = 200 + Math.random() * 200;
                    const cp2X = Math.random() * 512;
                    const cp2Y = 600 + Math.random() * 200;
                    const endX = Math.random() * 512;
                    
                    ctx.beginPath();
                    ctx.moveTo(startX, -50);
                    ctx.bezierCurveTo(cp1X, cp1Y, cp2X, cp2Y, endX, 1074);
                    ctx.stroke();
                }
                
                // Draw some cream/milk swirls overlapping the green
                ctx.strokeStyle = '#faf6ee';
                for (let i = 0; i < 4; i++) {
                    ctx.lineWidth = 60 + Math.random() * 50;
                    const startX = Math.random() * 512;
                    const cp1X = Math.random() * 512;
                    const cp1Y = 300 + Math.random() * 400;
                    const endX = Math.random() * 512;
                    
                    ctx.beginPath();
                    ctx.moveTo(startX, 1074);
                    ctx.quadraticCurveTo(cp1X, cp1Y, endX, -50);
                    ctx.stroke();
                }
                
                // Opaque rich matcha layer at the top (matcha floats on top in a latte)
                const topGrad = ctx.createLinearGradient(0, 0, 0, 450);
                topGrad.addColorStop(0, '#2b4718');
                topGrad.addColorStop(0.25, '#385c21');
                topGrad.addColorStop(0.65, 'rgba(75, 117, 48, 0.65)');
                topGrad.addColorStop(1, 'rgba(250, 246, 238, 0)');
                ctx.fillStyle = topGrad;
                ctx.fillRect(0, 0, 512, 450);
                
                // Turn off filter
                try {
                    ctx.filter = 'none';
                } catch(e) {}
                
                // Add soft shading gradient for volumetric depth
                ctx.globalCompositeOperation = 'multiply';
                const shadowGrad = ctx.createLinearGradient(0, 0, 0, 1024);
                shadowGrad.addColorStop(0, '#ffffff');
                shadowGrad.addColorStop(0.5, '#eaeaea');
                shadowGrad.addColorStop(1, '#b5b5b5');
                ctx.fillStyle = shadowGrad;
                ctx.fillRect(0, 0, 512, 1024);
                ctx.globalCompositeOperation = 'source-over';

                const texture = new THREE.CanvasTexture(canvas);
                texture.wrapS = THREE.RepeatWrapping;
                texture.wrapT = THREE.ClampToEdgeWrapping;
                return texture;
            }
            
            const liquidTexture = createMarbledTexture();
            const liquidPoints = [];
            liquidPoints.push(new THREE.Vector2(0, -1.53)); // Inner bottom offset to prevent z-fighting
            liquidPoints.push(new THREE.Vector2(0.95, -1.53));
            liquidPoints.push(new THREE.Vector2(1.02, -1.0));
            liquidPoints.push(new THREE.Vector2(1.10, 0.0));
            liquidPoints.push(new THREE.Vector2(1.18, 1.0));
            liquidPoints.push(new THREE.Vector2(1.23, 1.42)); // Match foam interface height
            liquidPoints.push(new THREE.Vector2(0, 1.42));
            
            const liquidGeo = new THREE.LatheGeometry(liquidPoints, 64);
            const liquidMaterial = new THREE.MeshPhysicalMaterial({
                map: liquidTexture,
                roughness: 0.38, // Milky matte/satin reflection
                metalness: 0.0,
                transmission: 0.12, // Slight rim translucent light scattering
                thickness: 0.1,
                envMapIntensity: 0.9
            });
            const liquidMesh = new THREE.Mesh(liquidGeo, liquidMaterial);
            cupGroup.add(liquidMesh);

            // C. Textured Frothy Foam Dome
            function createFoamBumpTexture() {
                const canvas = document.createElement('canvas');
                canvas.width = 256;
                canvas.height = 256;
                const ctx = canvas.getContext('2d');
                ctx.fillStyle = '#808080';
                ctx.fillRect(0, 0, 256, 256);
                
                // Draw thousands of tiny micro-foam specs
                for (let i = 0; i < 9000; i++) {
                    const x = Math.random() * 256;
                    const y = Math.random() * 256;
                    const size = 0.4 + Math.random() * 1.6;
                    const b = Math.floor(Math.random() * 90) - 45;
                    ctx.fillStyle = `rgb(${128 + b}, ${128 + b}, ${128 + b})`;
                    ctx.beginPath();
                    ctx.arc(x, y, size, 0, Math.PI * 2);
                    ctx.fill();
                }
                
                const texture = new THREE.CanvasTexture(canvas);
                texture.wrapS = THREE.RepeatWrapping;
                texture.wrapT = THREE.RepeatWrapping;
                texture.repeat.set(4, 4);
                return texture;
            }
            const foamBump = createFoamBumpTexture();

            const foamPoints = [];
            foamPoints.push(new THREE.Vector2(0, 1.54)); // High center dome
            foamPoints.push(new THREE.Vector2(0.7, 1.52));
            foamPoints.push(new THREE.Vector2(1.1, 1.47));
            foamPoints.push(new THREE.Vector2(1.23, 1.42)); // outer edge matching glass inner
            foamPoints.push(new THREE.Vector2(1.21, 1.36));
            foamPoints.push(new THREE.Vector2(0, 1.36));
            
            const foamGeo = new THREE.LatheGeometry(foamPoints, 48);
            const foamMaterial = new THREE.MeshStandardMaterial({
                color: 0x5a7b39, // Richer green to avoid light washout
                roughness: 0.98,
                metalness: 0.02,
                bumpMap: foamBump,
                bumpScale: 0.016,
                envMapIntensity: 0.15
            });
            const foamMesh = new THREE.Mesh(foamGeo, foamMaterial);
            cupGroup.add(foamMesh);

            // D. Air Bubbles
            const bubbleGeo = new THREE.SphereGeometry(1, 8, 8);
            const bubbleMat = new THREE.MeshPhysicalMaterial({
                color: 0xdaeed2,
                transparent: true,
                opacity: 0.55,
                roughness: 0.02,
                transmission: 0.95,
                ior: 1.15,
                thickness: 0.02,
                depthWrite: false,
                envMapIntensity: 1.4
            });

            // 1. Foam cap surface bubbles
            for (let i = 0; i < 35; i++) {
                const bubble = new THREE.Mesh(bubbleGeo, bubbleMat);
                const size = 0.022 + Math.random() * 0.055;
                bubble.scale.set(size, size, size);
                
                const angle = Math.random() * Math.PI * 2;
                const radius = 0.4 + Math.random() * 0.78;
                bubble.position.set(
                    Math.cos(angle) * radius,
                    1.47 + Math.random() * 0.05,
                    Math.sin(angle) * radius
                );
                cupGroup.add(bubble);
            }

            // 2. Tiny carbon/air bubbles clinging to inner glass wall
            for (let i = 0; i < 22; i++) {
                const bubble = new THREE.Mesh(bubbleGeo, bubbleMat);
                const size = 0.012 + Math.random() * 0.018;
                bubble.scale.set(size, size, size);
                
                const y = -1.4 + Math.random() * 2.6;
                const theta = Math.random() * Math.PI * 2;
                const R_inner = getGlassOuterRadius(y) - 0.08;
                
                bubble.position.set(
                    Math.cos(theta) * R_inner,
                    y,
                    Math.sin(theta) * R_inner
                );
                cupGroup.add(bubble);
            }

            // E. Procedural Condensation Droplets (Outer glass wall)
            const dropletGeo = new THREE.SphereGeometry(1, 8, 8);
            const dropletMat = new THREE.MeshPhysicalMaterial({
                color: 0xffffff,
                transparent: true,
                opacity: 0.85, // More opaque to stand out as glistening water drops
                roughness: 0.0,
                transmission: 0.95,
                ior: 1.333,
                thickness: 0.03,
                depthWrite: false,
                envMapIntensity: 2.2
            });

            // 75 tiny static condensation drops
            for (let i = 0; i < 75; i++) {
                const droplet = new THREE.Mesh(dropletGeo, dropletMat);
                const size = 0.025 + Math.random() * 0.035; // scaled up to make visible
                droplet.scale.set(size, size, size * 0.55); // flattened droplet shape
                
                const y = -1.45 + Math.random() * 2.85;
                const theta = Math.random() * Math.PI * 2;
                const R = getGlassOuterRadius(y);
                const offset = 0.005; // Offset outside outer glass surface to prevent clipping
                
                droplet.position.set(
                    Math.cos(theta) * (R + offset),
                    y,
                    Math.sin(theta) * (R + offset)
                );
                droplet.rotation.y = -theta;
                cupGroup.add(droplet);
            }

            // 6 running water trails
            const runGeo = new THREE.CylinderGeometry(0.018, 0.018, 0.22, 8, 1);
            for (let i = 0; i < 6; i++) {
                const trail = new THREE.Mesh(runGeo, dropletMat);
                const w = 0.75 + Math.random() * 0.35;
                const h = 0.8 + Math.random() * 0.9;
                trail.scale.set(w, h, w);
                
                const y = -0.7 + Math.random() * 1.7;
                const theta = Math.random() * Math.PI * 2;
                const R = getGlassOuterRadius(y);
                const offset = 0.005;
                
                trail.position.set(
                    Math.cos(theta) * (R + offset),
                    y,
                    Math.sin(theta) * (R + offset)
                );
                trail.rotation.y = -theta;
                cupGroup.add(trail);
            }

            // F. Ultra-Refractive Ice Cubes (Subdivided & deformed for melted look, floating higher)
            const iceMaterial = new THREE.MeshPhysicalMaterial({
                color: 0xffffff,
                transparent: true,
                opacity: 0.52, // high opacity for water ice block look
                roughness: 0.02,
                metalness: 0.05,
                clearcoat: 1.0,
                clearcoatRoughness: 0.02,
                depthWrite: true, // depth write for correct layering on foam
                envMapIntensity: 2.5
            });

            function createIceGeometry(sizeX, sizeY, sizeZ) {
                const geo = new THREE.BoxGeometry(sizeX, sizeY, sizeZ, 4, 4, 4);
                const pos = geo.attributes.position;
                
                for (let i = 0; i < pos.count; i++) {
                    let x = pos.getX(i);
                    let y = pos.getY(i);
                    let z = pos.getZ(i);
                    
                    const len = Math.sqrt(x*x + y*y + z*z);
                    const maxDim = Math.max(Math.abs(sizeX), Math.max(Math.abs(sizeY), Math.abs(sizeZ))) * 0.5;
                    const sphereRatio = 0.36; // blend boxes into soft ice blocks
                    
                    const rx = x / len * maxDim;
                    const ry = y / len * maxDim;
                    const rz = z / len * maxDim;
                    
                    x = x * (1 - sphereRatio) + rx * sphereRatio;
                    y = y * (1 - sphereRatio) + ry * sphereRatio;
                    z = z * (1 - sphereRatio) + rz * sphereRatio;
                    
                    // Subtle organic surface distortion
                    const d = 0.025;
                    x += (Math.random() - 0.5) * d;
                    y += (Math.random() - 0.5) * d;
                    z += (Math.random() - 0.5) * d;
                    
                    pos.setXYZ(i, x, y, z);
                }
                geo.computeVertexNormals();
                return geo;
            }

            // Ice 1 (large, floating high)
            const ice1 = new THREE.Mesh(createIceGeometry(0.58, 0.58, 0.58), iceMaterial);
            ice1.position.set(-0.35, 1.35, 0.2);
            ice1.rotation.set(0.4, 0.2, 0.6);
            cupGroup.add(ice1);

            // Ice 2 (medium, floating high)
            const ice2 = new THREE.Mesh(createIceGeometry(0.52, 0.52, 0.52), iceMaterial);
            ice2.position.set(0.35, 1.25, -0.2);
            ice2.rotation.set(0.7, 0.9, 0.1);
            cupGroup.add(ice2);

            // Ice 3 (small, breaking through top foam dome)
            const ice3 = new THREE.Mesh(createIceGeometry(0.46, 0.46, 0.46), iceMaterial);
            ice3.position.set(-0.05, 1.48, -0.2);
            ice3.rotation.set(0.2, 0.5, 0.8);
            cupGroup.add(ice3);

            // G. Shiny Gold Straw
            const strawMaterial = new THREE.MeshPhysicalMaterial({
                color: 0xd4af37, // Metallic gold
                roughness: 0.08,
                metalness: 0.96,
                clearcoat: 1.0,
                clearcoatRoughness: 0.02,
                envMapIntensity: 2.4
            });
            const strawGeo = new THREE.CylinderGeometry(0.065, 0.065, 4.8, 20);
            const straw = new THREE.Mesh(strawGeo, strawMaterial);
            straw.castShadow = true;
            straw.position.set(0.4, 0.8, -0.3);
            straw.rotation.set(0.25, 0.0, -0.26); // rested leaning angle
            cupGroup.add(straw);

            // 9. Animation and Idle Cycles
            const clock = new THREE.Clock();

            function animate() {
                requestAnimationFrame(animate);

                const elapsed = clock.getElapsedTime();
                
                // Soft floating height bounce
                cupGroup.position.y = Math.sin(elapsed * 1.1) * 0.07;
                
                // Slow realistic idle rotate (shifts reflections dynamically)
                cupGroup.rotation.y = elapsed * 0.08;

                controls.update();
                renderer.render(scene, camera);
            }
            animate();

            // 10. Canvas Resize Observer
            const resizeObserver = new ResizeObserver(entries => {
                for (let entry of entries) {
                    const newWidth = entry.contentRect.width;
                    const newHeight = entry.contentRect.height;
                    
                    camera.aspect = newWidth / newHeight;
                    camera.updateProjectionMatrix();
                    renderer.setSize(newWidth, newHeight);
                }
            });
            resizeObserver.observe(container);
        });
    </script>

</body>
</html>
