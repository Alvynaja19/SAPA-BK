/**
 * SAPA BK - Hero 3D Scene (Three.js)
 * Visual motif: Educational guidance (mortarboard, book, pencil)
 * Designed for low-overhead performance with IntersectionObserver and reduced-motion checks.
 */

(function () {
  const isReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  const canvasHost = document.getElementById('heroCanvas');
  const heroSection = document.getElementById('hero');

  if (!canvasHost || !heroSection || isReducedMotion || window.innerWidth < 900) {
    if (canvasHost) canvasHost.classList.add('static-fallback');
    return;
  }

  // Check WebGL support
  function hasWebGL() {
    try {
      const canvas = document.createElement('canvas');
      return !!(window.WebGLRenderingContext && (canvas.getContext('webgl') || canvas.getContext('experimental-webgl')));
    } catch {
      return false;
    }
  }

  if (!hasWebGL() || typeof THREE === 'undefined') {
    canvasHost.classList.add('static-fallback');
    return;
  }

  const width = canvasHost.clientWidth || 600;
  const height = canvasHost.clientHeight || 500;

  const scene = new THREE.Scene();
  const camera = new THREE.PerspectiveCamera(40, width / height, 0.1, 100);
  camera.position.set(0, 0, 13);

  let renderer;
  try {
    renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true, powerPreference: 'low-power' });
  } catch {
    canvasHost.classList.add('static-fallback');
    return;
  }

  renderer.setPixelRatio(Math.min(window.devicePixelRatio || 1, 1.5));
  renderer.setSize(width, height);
  canvasHost.appendChild(renderer.domElement);

  // Lighting setup with school palette tones
  const ambientLight = new THREE.AmbientLight(0xFBF5DC, 0.85);
  scene.add(ambientLight);

  const keyLight = new THREE.DirectionalLight(0xF4B400, 1.0);
  keyLight.position.set(6, 8, 6);
  scene.add(keyLight);

  const fillLight = new THREE.DirectionalLight(0x8FC98F, 0.5);
  fillLight.position.set(-6, -4, 4);
  scene.add(fillLight);

  const group = new THREE.Group();
  scene.add(group);

  // 1. Mortarboard (Topi Toga)
  const cap = new THREE.Group();
  const board = new THREE.Mesh(
    new THREE.BoxGeometry(3.0, 0.15, 3.0),
    new THREE.MeshStandardMaterial({ color: 0x2E7D34, flatShading: true, roughness: 0.5 })
  );
  cap.add(board);

  const capBase = new THREE.Mesh(
    new THREE.CylinderGeometry(0.6, 0.7, 0.48, 8),
    new THREE.MeshStandardMaterial({ color: 0x1C2B18, flatShading: true, roughness: 0.55 })
  );
  capBase.position.y = -0.38;
  cap.add(capBase);

  const capButton = new THREE.Mesh(
    new THREE.CylinderGeometry(0.15, 0.15, 0.18, 8),
    new THREE.MeshStandardMaterial({ color: 0xF4B400, flatShading: true, roughness: 0.4 })
  );
  capButton.position.y = 0.16;
  cap.add(capButton);

  const tasselPivot = new THREE.Group();
  tasselPivot.position.set(1.35, 0.1, 1.3);
  cap.add(tasselPivot);

  const tasselCord = new THREE.Mesh(
    new THREE.CylinderGeometry(0.03, 0.03, 1.2, 6),
    new THREE.MeshStandardMaterial({ color: 0xF4B400, flatShading: true, roughness: 0.5 })
  );
  tasselCord.position.y = -0.6;
  tasselPivot.add(tasselCord);

  const tasselEnd = new THREE.Mesh(
    new THREE.SphereGeometry(0.13, 8, 8),
    new THREE.MeshStandardMaterial({ color: 0xF4B400, flatShading: true, roughness: 0.5 })
  );
  tasselEnd.position.y = -1.25;
  tasselPivot.add(tasselEnd);

  cap.position.set(-0.3, 0.85, 0.3);
  cap.rotation.set(0.16, 0.14, 0);
  group.add(cap);

  // 2. Open Book
  const book = new THREE.Group();
  const spine = new THREE.Mesh(
    new THREE.BoxGeometry(0.1, 0.12, 1.4),
    new THREE.MeshStandardMaterial({ color: 0x1C6EB4, flatShading: true, roughness: 0.5 })
  );
  book.add(spine);

  const pageLeftPivot = new THREE.Group();
  const pageLeft = new THREE.Mesh(
    new THREE.BoxGeometry(1.4, 0.05, 1.3),
    new THREE.MeshStandardMaterial({ color: 0xFBF8EA, flatShading: true, roughness: 0.6 })
  );
  pageLeft.position.x = -0.7;
  pageLeftPivot.add(pageLeft);
  pageLeftPivot.rotation.z = 0.3;
  book.add(pageLeftPivot);

  const pageRightPivot = new THREE.Group();
  const pageRight = new THREE.Mesh(
    new THREE.BoxGeometry(1.4, 0.05, 1.3),
    new THREE.MeshStandardMaterial({ color: 0xFBF8EA, flatShading: true, roughness: 0.6 })
  );
  pageRight.position.x = 0.7;
  pageRightPivot.add(pageRight);
  pageRightPivot.rotation.z = -0.3;
  book.add(pageRightPivot);

  book.position.set(-2.4, -1.6, -1.0);
  book.rotation.set(-0.08, 0.52, 0);
  group.add(book);

  // 3. Pencil
  const pencil = new THREE.Group();
  const shaft = new THREE.Mesh(
    new THREE.CylinderGeometry(0.15, 0.15, 2.0, 6),
    new THREE.MeshStandardMaterial({ color: 0xF4B400, flatShading: true, roughness: 0.5 })
  );
  pencil.add(shaft);

  const tip = new THREE.Mesh(
    new THREE.ConeGeometry(0.15, 0.4, 6),
    new THREE.MeshStandardMaterial({ color: 0x8A5B00, flatShading: true, roughness: 0.6 })
  );
  tip.position.y = 1.2;
  pencil.add(tip);

  const graphite = new THREE.Mesh(
    new THREE.ConeGeometry(0.045, 0.12, 6),
    new THREE.MeshStandardMaterial({ color: 0x1C2B18, flatShading: true })
  );
  graphite.position.y = 1.42;
  pencil.add(graphite);

  const eraser = new THREE.Mesh(
    new THREE.CylinderGeometry(0.15, 0.15, 0.28, 6),
    new THREE.MeshStandardMaterial({ color: 0xD6362E, flatShading: true, roughness: 0.5 })
  );
  eraser.position.y = -1.28;
  pencil.add(eraser);

  pencil.position.set(2.4, 1.2, -0.6);
  pencil.rotation.set(0.18, 0, 0.52);
  group.add(pencil);

  // Floating accent motifs
  const floaters = [];
  const palette = [0x2E7D34, 0xF4B400, 0x1C6EB4, 0xD6362E];
  for (let i = 0; i < 6; i++) {
    const size = 0.14 + Math.random() * 0.1;
    const mesh = new THREE.Mesh(
      new THREE.OctahedronGeometry(size, 0),
      new THREE.MeshStandardMaterial({ color: palette[i % palette.length], flatShading: true, roughness: 0.5 })
    );
    const angle = (i / 6) * Math.PI * 2;
    const radius = 4.2 + Math.random() * 1.0;
    mesh.userData = { speed: 0.15 + Math.random() * 0.12, yOff: Math.random() * Math.PI * 2 };
    mesh.position.set(Math.cos(angle) * radius, Math.sin(angle * 1.2) * 1.2, Math.sin(angle) * radius - 2);
    group.add(mesh);
    floaters.push(mesh);
  }

  let targetRotX = 0.35;
  let targetRotY = -0.35;
  group.rotation.set(targetRotX, targetRotY, 0);

  heroSection.addEventListener('mousemove', (e) => {
    const rect = heroSection.getBoundingClientRect();
    const nx = (e.clientX - rect.left) / rect.width - 0.5;
    const ny = (e.clientY - rect.top) / rect.height - 0.5;
    targetRotY = -0.35 + nx * 0.45;
    targetRotX = 0.35 + ny * 0.24;
  });

  function onResize() {
    const w = canvasHost.clientWidth;
    const h = canvasHost.clientHeight;
    if (w === 0 || h === 0) return;
    camera.aspect = w / h;
    camera.updateProjectionMatrix();
    renderer.setSize(w, h);
  }
  window.addEventListener('resize', onResize);

  // Use IntersectionObserver to pause rendering when hero is out of view
  let isVisible = true;
  if ('IntersectionObserver' in window) {
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        isVisible = entry.isIntersecting;
      });
    }, { threshold: 0.05 });
    observer.observe(heroSection);
  }

  const clock = new THREE.Clock();
  function animate() {
    requestAnimationFrame(animate);
    if (!isVisible) return;

    const t = clock.getElapsedTime();

    group.rotation.x += (targetRotX - group.rotation.x) * 0.04;
    group.rotation.y += (targetRotY - group.rotation.y) * 0.04;

    tasselPivot.rotation.z = Math.sin(t * 0.7) * 0.12;
    pageLeftPivot.rotation.z = 0.3 + Math.sin(t * 0.5) * 0.025;
    pageRightPivot.rotation.z = -0.3 - Math.sin(t * 0.5) * 0.025;
    pencil.rotation.y = Math.sin(t * 0.35) * 0.4;
    cap.position.y = 0.85 + Math.sin(t * 0.6) * 0.05;

    floaters.forEach((f) => {
      const d = f.userData;
      f.position.y += Math.sin(t * d.speed * 2 + d.yOff) * 0.015;
      f.rotation.x += 0.003;
      f.rotation.y += 0.005;
    });

    renderer.render(scene, camera);
  }
  animate();
})();
