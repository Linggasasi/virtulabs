import * as THREE from 'three';
import { initializeJakartaClocks } from './jakarta-clock';

initializeJakartaClocks();

(() => {
    const toast = (message) => {
        const node = document.getElementById('vlToast');
        if (!node) return;
        node.textContent = message;
        node.classList.add('is-visible');
        window.clearTimeout(toast.timer);
        toast.timer = window.setTimeout(() => node.classList.remove('is-visible'), 2800);
    };

    const mobileMenu = document.getElementById('vlMobileMenu');
    const sidebar = document.getElementById('vlSidebar');
    mobileMenu?.addEventListener('click', () => sidebar?.classList.toggle('is-open'));
    document.addEventListener('click', (event) => {
        if (window.innerWidth <= 900 && sidebar?.classList.contains('is-open') && !sidebar.contains(event.target) && !mobileMenu?.contains(event.target)) sidebar.classList.remove('is-open');
    });

    const labRoot = document.getElementById('virtulabLab');
    if (!labRoot) return;

    const slug = labRoot.dataset.lab;
    const tabButtons = [...document.querySelectorAll('[data-mode]')];
    const panels = [...document.querySelectorAll('[data-panel]')];
    const switchMode = (mode) => {
        tabButtons.forEach((button) => {
            const active = button.dataset.mode === mode;
            button.classList.toggle('is-active', active);
            button.setAttribute('aria-selected', String(active));
        });
        panels.forEach((panel) => {
            const active = panel.dataset.panel === mode;
            panel.classList.toggle('is-active', active);
            panel.hidden = !active;
        });
        if (mode === 'practice') window.setTimeout(() => scene?.resize(), 80);
        document.querySelector('.vl-mode-tabs')?.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    };
    tabButtons.forEach((button) => button.addEventListener('click', () => switchMode(button.dataset.mode)));
    document.querySelector('[data-go-practice]')?.addEventListener('click', () => switchMode('practice'));

    const resultGrid = document.getElementById('vlResultGrid');
    const resultState = document.getElementById('vlResultState');
    const setResults = (cards, state = 'Hasil diperbarui') => {
        if (!resultGrid) return;
        resultGrid.innerHTML = cards.map((card) => `<div class="vl-result-card"><small>${card.label}</small><strong>${card.value}</strong><span>${card.note}</span></div>`).join('');
        if (resultState) resultState.textContent = state;
    };

    // 3D scene: deliberately lightweight geometry to keep the Laravel page responsive.
    let scene = null;
    const viewport = document.getElementById('vlSceneViewport');
    const loading = document.getElementById('vlSceneLoading');
    const selectedLabel = document.getElementById('vlSelectedObject');

    if (viewport) {
        try {
            scene = createLabScene(viewport, slug, {
                onSelect: (name) => { if (selectedLabel) selectedLabel.textContent = `Objek dipilih: ${name}`; },
                onReady: () => loading?.classList.add('is-hidden'),
                onError: (message) => { if (loading) loading.innerHTML = `<strong>3D tidak dapat dimuat</strong><small>${message}</small>`; },
                onToast: toast,
            });
        } catch (error) {
            if (loading) loading.innerHTML = '<strong>Browser tidak mendukung WebGL</strong><small>Coba gunakan Microsoft Edge atau Chrome versi terbaru.</small>';
            console.error(error);
        }
    }

    const read = (id) => Number(document.getElementById(id)?.value ?? 0);
    const bindRange = (id, outputId, formatter) => {
        const input = document.getElementById(id);
        const output = document.getElementById(outputId);
        if (!input || !output) return;
        const update = () => { output.textContent = formatter(Number(input.value)); };
        input.addEventListener('input', update);
        update();
    };

    if (slug === 'physics') {
        bindRange('physicsSpeed', 'physicsSpeedValue', (v) => `${v} m/s`);
        bindRange('physicsAngle', 'physicsAngleValue', (v) => `${v}°`);
        const updateScene = () => scene?.setPhysics?.({ speed: read('physicsSpeed'), angle: read('physicsAngle'), gravity: read('physicsGravity') });
        ['physicsSpeed', 'physicsAngle', 'physicsGravity'].forEach((id) => document.getElementById(id)?.addEventListener('input', updateScene));
        document.getElementById('runPhysics')?.addEventListener('click', () => {
            const speed = read('physicsSpeed'); const angle = read('physicsAngle') * Math.PI / 180; const gravity = read('physicsGravity');
            const time = (2 * speed * Math.sin(angle)) / gravity;
            const range = (speed * speed * Math.sin(2 * angle)) / gravity;
            const height = (speed * speed * Math.sin(angle) ** 2) / (2 * gravity);
            scene?.animateProjectile?.({ speed, angle: read('physicsAngle'), gravity, time, range, height });
            setResults([
                { label: 'JARAK HORIZONTAL', value: `${range.toFixed(2)} m`, note: 'Jarak saat proyektil kembali ke ketinggian awal.' },
                { label: 'TINGGI MAKSIMUM', value: `${height.toFixed(2)} m`, note: 'Ketinggian tertinggi dari titik peluncuran.' },
                { label: 'WAKTU TOTAL', value: `${time.toFixed(2)} s`, note: 'Waktu hingga proyektil kembali ke ketinggian awal.' },
            ], 'Simulasi selesai');
            toast('Peluncuran berhasil dijalankan. Amati lintasan 3D.');
        });
        updateScene();
    }

    if (slug === 'chemistry') {
        bindRange('vinegarVolume', 'vinegarValue', (v) => `${v} mL`);
        bindRange('bakingSoda', 'sodaValue', (v) => `${v} g`);
        let vinegarAdded = false; let sodaAdded = false;
        const updateMaterials = () => scene?.setChemistryMaterials?.({ vinegar: vinegarAdded, soda: sodaAdded, volume: read('vinegarVolume'), mass: read('bakingSoda') });
        document.getElementById('vinegarVolume')?.addEventListener('input', updateMaterials);
        document.getElementById('bakingSoda')?.addEventListener('input', updateMaterials);
        document.getElementById('addVinegar')?.addEventListener('click', () => { vinegarAdded = true; updateMaterials(); toast('Larutan cuka ditambahkan ke beaker.'); });
        document.getElementById('addSoda')?.addEventListener('click', () => { sodaAdded = true; updateMaterials(); toast('Soda kue ditambahkan ke beaker.'); });
        document.getElementById('runChemistry')?.addEventListener('click', () => {
            if (!vinegarAdded || !sodaAdded) { toast('Tambahkan cuka dan soda kue terlebih dahulu.'); return; }
            const acidMoles = (0.83 * (read('vinegarVolume') / 1000)); // 5% w/v vinegar approximation
            const baseMoles = read('bakingSoda') / 84.0066;
            const co2Moles = Math.min(acidMoles, baseMoles);
            const gasMl = co2Moles * 24.0 * 1000; // approximate molar gas volume at room conditions
            scene?.runChemistry?.({ gasMl, vinegar: read('vinegarVolume'), soda: read('bakingSoda') });
            setResults([
                { label: 'PEREAKSI PEMBATAS', value: acidMoles < baseMoles ? 'Asam asetat' : 'Natrium bikarbonat', note: 'Berdasarkan pendekatan jumlah mol 1:1.' },
                { label: 'ESTIMASI CO₂', value: `${gasMl.toFixed(0)} mL`, note: 'Perkiraan volume gas pada kondisi ruang asumsi.' },
                { label: 'STATUS REAKSI', value: 'Berlangsung', note: 'Visualisasi gelembung ditampilkan di beaker.' },
            ], 'Reaksi disimulasikan');
            toast('Reaksi dimulai. Perhatikan pembentukan gelembung.');
        });
        document.getElementById('resetExperiment')?.addEventListener('click', () => { vinegarAdded = false; sodaAdded = false; scene?.resetChemistry?.(); updateMaterials(); setResults([{label:'STATUS',value:'Siap',note:'Beaker telah dibersihkan.'},{label:'BAHAN',value:'0',note:'Belum ada bahan ditambahkan.'},{label:'PENGAMATAN',value:'—',note:'Mulai eksperimen baru.'}], 'Menunggu eksperimen'); });
    }

    if (slug === 'electrical') {
        bindRange('circuitVoltage', 'voltageValue', (v) => `${v} V`);
        bindRange('resistorOne', 'resistorOneValue', (v) => `${v} Ω`);
        bindRange('resistorTwo', 'resistorTwoValue', (v) => `${v} Ω`);
        let circuitType = 'series'; let isOn = false;
        document.querySelectorAll('[data-circuit]').forEach((button) => button.addEventListener('click', () => {
            circuitType = button.dataset.circuit;
            document.querySelectorAll('[data-circuit]').forEach((item) => item.classList.toggle('is-active', item === button));
            isOn = false; scene?.setCircuit?.({ on: false, type: circuitType });
        }));
        const update = () => scene?.setCircuit?.({ on: isOn, type: circuitType, voltage: read('circuitVoltage'), r1: read('resistorOne'), r2: read('resistorTwo') });
        ['circuitVoltage','resistorOne','resistorTwo'].forEach((id) => document.getElementById(id)?.addEventListener('input', update));
        document.getElementById('runCircuit')?.addEventListener('click', (event) => {
            isOn = !isOn; update();
            const button = event.currentTarget;
            button.innerHTML = isOn ? '<i class="vl-icon vl-icon-power"></i> Buka sakelar' : '<i class="vl-icon vl-icon-power"></i> Tutup sakelar';
            const r1 = read('resistorOne'); const r2 = read('resistorTwo'); const voltage = read('circuitVoltage');
            const total = circuitType === 'series' ? r1 + r2 : (r1 * r2) / (r1 + r2);
            const current = voltage / total; const power = voltage * current;
            setResults([
                { label: 'HAMBATAN TOTAL', value: `${total.toFixed(2)} Ω`, note: `Konfigurasi ${circuitType === 'series' ? 'seri' : 'paralel'}.` },
                { label: 'ARUS TOTAL', value: `${isOn ? current.toFixed(3) : '0.000'} A`, note: 'Arus berdasarkan Hukum Ohm.' },
                { label: 'DAYA TOTAL', value: `${isOn ? power.toFixed(2) : '0.00'} W`, note: 'Daya sumber pada kondisi simulasi.' },
            ], isOn ? 'Sakelar tertutup · arus mengalir' : 'Sakelar terbuka');
            toast(isOn ? 'Sirkuit aktif. Amati aliran elektron dan lampu.' : 'Sirkuit dimatikan.');
        });
        document.getElementById('resetExperiment')?.addEventListener('click', () => { isOn = false; update(); document.getElementById('runCircuit').innerHTML = '<i class="vl-icon vl-icon-power"></i> Tutup sakelar'; setResults([{label:'STATUS',value:'Terbuka',note:'Sakelar belum diaktifkan.'},{label:'ARUS',value:'0 A',note:'Tidak ada arus mengalir.'},{label:'DAYA',value:'0 W',note:'Sumber belum menyalurkan daya.'}], 'Rangkaian direset'); });
        update();
    }

    document.querySelectorAll('[data-camera]').forEach((button) => button.addEventListener('click', () => scene?.cameraAction?.(button.dataset.camera)));

    const worksheetKey = `virtulab:worksheet:${slug}`;
    const prediction = document.getElementById('experimentPrediction');
    const conclusion = document.getElementById('experimentConclusion');
    const status = document.getElementById('worksheetStatus');
    try {
        const saved = JSON.parse(localStorage.getItem(worksheetKey) || '{}');
        if (prediction) prediction.value = saved.prediction || '';
        if (conclusion) conclusion.value = saved.conclusion || '';
        if (saved.savedAt && status) status.textContent = `Catatan terakhir disimpan ${saved.savedAt}.`;
    } catch (_) { /* Ignore malformed local browser data. */ }
    document.getElementById('saveWorksheet')?.addEventListener('click', () => {
        const now = new Date().toLocaleString('id-ID', { dateStyle: 'medium', timeStyle: 'short' });
        localStorage.setItem(worksheetKey, JSON.stringify({ prediction: prediction?.value || '', conclusion: conclusion?.value || '', savedAt: now }));
        if (status) status.textContent = `Tersimpan pada ${now}.`;
        toast('Catatan eksperimen berhasil disimpan di browser ini.');
    });
})();

function createLabScene(container, type, callbacks) {
    const width = Math.max(container.clientWidth, 320);
    const height = Math.max(container.clientHeight, 300);
    const scene = new THREE.Scene();
    scene.background = new THREE.Color('#dce9e3');
    scene.fog = new THREE.Fog('#dce9e3', 13, 25);
    const camera = new THREE.PerspectiveCamera(36, width / height, 0.1, 100);
    camera.position.set(6.5, 5.0, 8.5);
    const renderer = new THREE.WebGLRenderer({ antialias: true, alpha: false });
    renderer.setPixelRatio(Math.min(window.devicePixelRatio, 1.8));
    renderer.setSize(width, height);
    renderer.shadowMap.enabled = true;
    renderer.shadowMap.type = THREE.PCFSoftShadowMap;
    renderer.outputColorSpace = THREE.SRGBColorSpace;
    renderer.toneMapping = THREE.ACESFilmicToneMapping;
    renderer.toneMappingExposure = 1.05;
    renderer.domElement.setAttribute('aria-label', 'Ruang laboratorium 3D interaktif');
    container.appendChild(renderer.domElement);

    scene.add(new THREE.HemisphereLight(0xf3fff8, 0x71847a, 2.1));
    const keyLight = new THREE.DirectionalLight(0xfff4df, 3.1);
    keyLight.position.set(-4, 8, 5); keyLight.castShadow = true; keyLight.shadow.mapSize.set(1024, 1024); scene.add(keyLight);
    const fillLight = new THREE.PointLight(0x9acfc1, 45, 18); fillLight.position.set(5, 4, -3); scene.add(fillLight);

    const mat = (color, roughness = .65, metalness = 0) => new THREE.MeshStandardMaterial({ color, roughness, metalness });
    const floorMat = mat('#d6e1d9'); const wallMat = mat('#e9eee8'); const woodMat = mat('#9b8066'); const woodTop = mat('#c6ad91'); const darkMetal = mat('#526b69', .35, .65); const steel = mat('#aabbb6', .25, .8); const glass = new THREE.MeshPhysicalMaterial({ color: '#d8ece7', transparent: true, opacity: .22, roughness: .08, metalness: .05, transmission: .45, thickness: .2 });
    const floor = new THREE.Mesh(new THREE.PlaneGeometry(22, 22), floorMat); floor.rotation.x = -Math.PI / 2; floor.position.y = -.03; floor.receiveShadow = true; scene.add(floor);
    const backWall = new THREE.Mesh(new THREE.PlaneGeometry(16, 7), wallMat); backWall.position.set(0, 3.4, -4.8); backWall.receiveShadow = true; scene.add(backWall);
    const sideWall = new THREE.Mesh(new THREE.PlaneGeometry(10, 7), mat('#e1eae4')); sideWall.rotation.y = Math.PI / 2; sideWall.position.set(-7.8, 3.4, 0); scene.add(sideWall);
    const windowFrame = new THREE.Group();
    const frame = new THREE.Mesh(new THREE.BoxGeometry(2.55, 1.7, .12), mat('#b7c9c0')); frame.position.set(-3.9, 3.4, -4.66); windowFrame.add(frame);
    const windowGlass = new THREE.Mesh(new THREE.PlaneGeometry(2.32, 1.48), new THREE.MeshBasicMaterial({ color: '#c2ded9' })); windowGlass.position.set(-3.9, 3.4, -4.58); windowFrame.add(windowGlass);
    const mullionV = new THREE.Mesh(new THREE.BoxGeometry(.045, 1.5, .05), mat('#f5f6ef')); mullionV.position.set(-3.9, 3.4, -4.53); windowFrame.add(mullionV);
    const mullionH = new THREE.Mesh(new THREE.BoxGeometry(2.3, .045, .05), mat('#f5f6ef')); mullionH.position.set(-3.9, 3.4, -4.53); windowFrame.add(mullionH); scene.add(windowFrame);
    addBox(scene, [0, 1.15, 0], [6.6, .22, 3.1], woodTop, true);
    for (const x of [-2.9, 2.9]) for (const z of [-1.25, 1.25]) addBox(scene, [x, .55, z], [.17, 1.1, .17], woodMat, true);
    addBox(scene, [0, .94, 0], [6.25, .08, 2.85], woodMat, false);
    addBox(scene, [-2.4, 1.28, -1.23], [1.25, .035, .13], darkMetal, false);
    addBox(scene, [2.35, 1.28, -1.23], [1.35, .035, .13], darkMetal, false);

    const interactive = [];
    const object = (mesh, name) => { mesh.userData.objectName = name; interactive.push(mesh); scene.add(mesh); return mesh; };
    const group = (name) => { const g = new THREE.Group(); g.userData.objectName = name; interactive.push(g); scene.add(g); return g; };
    const addOn = (parent, geometry, material, pos, cast = true) => { const m = new THREE.Mesh(geometry, material); m.position.set(...pos); m.castShadow = cast; m.receiveShadow = true; parent.add(m); return m; };

    const state = { projectile: null, trajectory: null, beakerLiquid: null, bubbles: [], reaction: false, switchOn: false, circuitPath: null, resistorMeshes: [], lampMaterial: null, draggable: [], selected: null };
    if (type === 'physics') {
        const base = group('Meja peluncur'); base.position.set(-1.3, 1.3, 0);
        addOn(base, new THREE.BoxGeometry(1.45, .16, .8), darkMetal, [0, 0, 0]);
        const rail = addOn(base, new THREE.CylinderGeometry(.085, .085, 1.65, 24), steel, [0, .25, 0]); rail.rotation.z = -Math.PI / 5;
        const rail2 = addOn(base, new THREE.CylinderGeometry(.085, .085, 1.65, 24), darkMetal, [0, .25, .19]); rail2.rotation.z = -Math.PI / 5;
        state.physicsRails = [rail, rail2];
        const hinge = addOn(base, new THREE.CylinderGeometry(.18, .18, .5, 28), mat('#58736e'), [-.25, .06, .1]); hinge.rotation.x = Math.PI / 2;
        const knob = addOn(base, new THREE.SphereGeometry(.14, 24, 16), mat('#d0a86e', .3, .35), [.34, .34, .39]); knob.userData.objectName = 'Kenop sudut peluncur';
        const ball = new THREE.Mesh(new THREE.SphereGeometry(.13, 32, 24), mat('#d8e0df', .18, .8)); ball.position.set(-.95, 1.97, 0); ball.castShadow = true; state.projectile = ball; object(ball, 'Bola proyektil');
        const target = group('Area pengamatan'); target.position.set(2.3, 1.28, .15);
        addOn(target, new THREE.CylinderGeometry(.055, .055, .6, 16), darkMetal, [0, .28, 0]);
        addOn(target, new THREE.CylinderGeometry(.3, .3, .07, 32), mat('#d1a86e'), [0, .62, 0]);
        addOn(target, new THREE.TorusGeometry(.2, .025, 8, 32), mat('#fff1d6'), [0, .67, 0]);
        state.trajectory = new THREE.Line(new THREE.BufferGeometry(), new THREE.LineBasicMaterial({ color: '#448d7b', transparent: true, opacity: .9 })); scene.add(state.trajectory);
        state.draggable.push({ mesh: knob, kind: 'physics-knob' });
    }

    if (type === 'chemistry') {
        const rack = group('Rak bahan kimia'); rack.position.set(-2.05, 1.3, -.55);
        const bottle = (parent, x, color, name) => {
            const b = new THREE.Group(); b.position.set(x, .04, 0); parent.add(b);
            addOn(b, new THREE.CylinderGeometry(.16, .2, .58, 24), new THREE.MeshPhysicalMaterial({ color, transparent: true, opacity: .58, roughness: .15, transmission: .5 }), [0, .3, 0]);
            addOn(b, new THREE.CylinderGeometry(.07, .07, .14, 20), glass, [0, .66, 0]);
            addOn(b, new THREE.CylinderGeometry(.085, .085, .09, 20), mat('#e4e7df'), [0, .77, 0]);
            b.userData.objectName = name; interactive.push(b); state.draggable.push({ mesh: b, kind: name });
            return b;
        };
        state.vinegarBottle = bottle(rack, -.4, '#b5d9e8', 'Botol cuka');
        state.sodaBottle = bottle(rack, .45, '#eadfc8', 'Wadah soda kue');
        const beaker = group('Beaker reaksi'); beaker.position.set(.65, 1.31, -.1);
        addOn(beaker, new THREE.CylinderGeometry(.43, .34, .9, 48, 1, true), glass, [0, .48, 0], false);
        addOn(beaker, new THREE.TorusGeometry(.42, .035, 10, 48), steel, [0, .94, 0]);
        addOn(beaker, new THREE.CylinderGeometry(.34, .34, .055, 40), glass, [0, .05, 0], false);
        state.beakerLiquid = addOn(beaker, new THREE.CylinderGeometry(.32, .32, .22, 40), new THREE.MeshPhysicalMaterial({ color: '#b9dce5', transparent: true, opacity: .7, roughness: .12, transmission: .65 }), [0, .2, 0], false);
        state.beaker = beaker;
        const stir = addOn(beaker, new THREE.CylinderGeometry(.025, .025, .8, 14), steel, [.62, .43, .1]); stir.rotation.z = -.35; stir.userData.objectName = 'Batang pengaduk'; interactive.push(stir);
        const shelf = addBox(scene, [-2.1, 1.43, -.55], [1.35, .09, .75], woodMat, true); shelf.position.y = 1.34;
        state.bubbles = [];
        for (let i=0;i<18;i++) { const bubble = new THREE.Mesh(new THREE.SphereGeometry(.025 + Math.random()*.025, 10, 8), new THREE.MeshBasicMaterial({ color: '#f5ffff', transparent: true, opacity: .75 })); bubble.visible = false; bubble.position.set(.65+(Math.random()-.5)*.5, 1.5+Math.random()*.35, -.1+(Math.random()-.5)*.5); scene.add(bubble); state.bubbles.push(bubble); }
    }

    if (type === 'electrical') {
        const board = group('Papan rangkaian'); board.position.set(.15, 1.32, -.1);
        addOn(board, new THREE.BoxGeometry(3.2, .13, 1.75), mat('#6d927b'), [0, 0, 0]);
        const railMaterial = mat('#d1c7a5', .4, .35);
        for (const z of [-.63, .63]) addOn(board, new THREE.BoxGeometry(2.85, .025, .035), railMaterial, [0, .08, z]);
        for (let i=0;i<13;i++) for (const z of [-.42,-.3,.3,.42]) addOn(board, new THREE.CylinderGeometry(.018,.018,.018,8), mat('#3e6259'), [-1.3+i*.21,.085,z], false);
        const resistor = (x, label, value) => {
            const g = new THREE.Group(); g.position.set(x, .15, 0); board.add(g); g.userData.objectName = `Resistor ${label}`;
            addOn(g, new THREE.CylinderGeometry(.09,.09,.33,20), mat('#d5b781'), [0,.08,0]).rotation.z = Math.PI/2;
            for (const z of [-.25,.25]) { const lead = addOn(g, new THREE.CylinderGeometry(.018,.018,.38,10), steel, [z,.08,0]); lead.rotation.z=Math.PI/2; }
            for (let n=0;n<3;n++) { const band = addOn(g, new THREE.CylinderGeometry(.095,.095,.025,20), mat(['#70503a','#b87938','#4a3a2f'][n]), [-.08+n*.09,.08,0]); band.rotation.z=Math.PI/2; }
            interactive.push(g); state.resistorMeshes.push(g); return g;
        };
        state.resistorMeshes = [resistor(-.75,'R1',100), resistor(.45,'R2',220)];
        state.resistorMeshes.forEach((mesh, index) => state.draggable.push({ mesh, kind: 'resistor', index }));
        const battery = group('Baterai DC'); battery.position.set(-2.0, 1.34, .55);
        addOn(battery,new THREE.BoxGeometry(.65,.35,.42),mat('#536d70'),[0,.1,0]);
        addOn(battery,new THREE.CylinderGeometry(.08,.08,.08,16),steel,[-.17,.32,0]); addOn(battery,new THREE.CylinderGeometry(.08,.08,.08,16),mat('#c57c65'),[.17,.32,0]);
        const lamp = group('Lampu indikator'); lamp.position.set(2.05,1.34,.48);
        addOn(lamp,new THREE.CylinderGeometry(.12,.16,.24,20),steel,[0,.13,0]);
        state.lampMaterial = new THREE.MeshStandardMaterial({color:'#fff0b7', emissive:'#000000', emissiveIntensity:0.2, roughness:.2});
        addOn(lamp,new THREE.SphereGeometry(.2,24,18),state.lampMaterial,[0,.38,0]);
        const wireMat = new THREE.MeshStandardMaterial({color:'#b55f50',roughness:.4});
        state.wires = [];
        const wire = (points,color) => { const curve=new THREE.CatmullRomCurve3(points.map(p=>new THREE.Vector3(...p))); const mesh=new THREE.Mesh(new THREE.TubeGeometry(curve,32,.025,8,false),new THREE.MeshStandardMaterial({color,roughness:.4,emissive:'#000000'})); scene.add(mesh); state.wires.push(mesh); };
        wire([[-2,1.8,.55],[-1.8,2.05,.55],[-1.3,1.95,.3],[-.8,1.8,-.1]],'#ba6454');
        wire([[.7,1.8,-.1],[1.2,2.0,.15],[1.7,1.85,.48],[2.05,1.7,.48]],'#527d91');
        wire([[2.05,1.7,.48],[2.6,1.8,.8],[2.9,1.6,.7],[2.2,1.4,-.9]],'#ba6454');
        state.electronDots=[];
        for(let i=0;i<12;i++){const dot=new THREE.Mesh(new THREE.SphereGeometry(.035,10,8),new THREE.MeshBasicMaterial({color:'#b5e5d1'}));dot.visible=false;scene.add(dot);state.electronDots.push(dot);}
    }

    // A few small scene details make the room feel occupied without heavy assets.
    for (const x of [-3.1, 3.0]) { const stool = new THREE.Group(); stool.position.set(x,0,-2.25); addOn(stool,new THREE.CylinderGeometry(.38,.38,.12,28),mat('#7d9d91'),[0,.68,0]); addOn(stool,new THREE.CylinderGeometry(.06,.07,.68,16),darkMetal,[0,.32,0]); scene.add(stool); }
    const grid = new THREE.GridHelper(14, 28, '#c2d4ca', '#d0ddd5'); grid.position.y=.002; grid.material.transparent=true; grid.material.opacity=.27; scene.add(grid);

    let pointerDown = false; let draggingObject = null; let prev = {x:0,y:0}; let theta = Math.atan2(camera.position.x,camera.position.z); let phi = Math.acos(camera.position.y / camera.position.length()); let radius = camera.position.length();
    const target = new THREE.Vector3(0,1.1,0); const raycaster = new THREE.Raycaster(); const pointer = new THREE.Vector2();
    const updateCamera = () => { phi=Math.max(.3,Math.min(1.35,phi)); radius=Math.max(5,Math.min(15,radius)); camera.position.set(target.x+radius*Math.sin(phi)*Math.sin(theta),target.y+radius*Math.cos(phi),target.z+radius*Math.sin(phi)*Math.cos(theta)); camera.lookAt(target); };
    updateCamera();
    const setPointer = (event) => { const rect=renderer.domElement.getBoundingClientRect(); pointer.x=((event.clientX-rect.left)/rect.width)*2-1; pointer.y=-((event.clientY-rect.top)/rect.height)*2+1; raycaster.setFromCamera(pointer,camera); };
    const dragPlane = new THREE.Plane(new THREE.Vector3(0, 1, 0), -1.48);
    const dragPoint = new THREE.Vector3();
    const findNamedRoot = (node) => { let current=node; while(current && !current.userData.objectName) current=current.parent; return current; };
    renderer.domElement.addEventListener('pointerdown',(event)=>{
        pointerDown=true; prev={x:event.clientX,y:event.clientY}; setPointer(event);
        const hit=raycaster.intersectObjects(interactive,true)[0];
        if(hit){
            const selected=findNamedRoot(hit.object) || hit.object;
            callbacks.onSelect?.(selected.userData.objectName||'Peralatan');
            draggingObject=state.draggable.find(item=>item.mesh===selected) || null;
            if(type==='chemistry'&&selected===state.vinegarBottle)callbacks.onToast?.('Botol cuka dipilih. Seret ke area beaker atau gunakan tombol bahan.');
            if(type==='chemistry'&&selected===state.sodaBottle)callbacks.onToast?.('Wadah soda kue dipilih. Seret ke area beaker atau gunakan tombol bahan.');
            if(type==='electrical' && selected.userData.objectName?.startsWith('Resistor')) callbacks.onToast?.('Komponen dipilih. Seret untuk mengatur posisinya di papan.');
        }
        renderer.domElement.setPointerCapture(event.pointerId);
    });
    renderer.domElement.addEventListener('pointermove',(event)=>{
        if(!pointerDown)return;
        const dx=event.clientX-prev.x; const dy=event.clientY-prev.y;
        if(draggingObject && (draggingObject.kind==='resistor' || draggingObject.kind==='Botol cuka' || draggingObject.kind==='Wadah soda kue')){
            setPointer(event);
            if(raycaster.ray.intersectPlane(dragPlane,dragPoint)){
                const mesh=draggingObject.mesh;
                const local=mesh.parent ? mesh.parent.worldToLocal(dragPoint.clone()) : dragPoint;
                if(draggingObject.kind==='resistor'){
                    mesh.position.x=THREE.MathUtils.clamp(local.x,-1.25,1.25);
                    mesh.position.z=THREE.MathUtils.clamp(local.z,-.48,.48);
                } else {
                    mesh.position.x=THREE.MathUtils.clamp(local.x,-.6,1.15);
                    mesh.position.z=THREE.MathUtils.clamp(local.z,-.55,.55);
                }
            }
        } else if(draggingObject && draggingObject.kind==='physics-knob') {
            const angleInput=document.getElementById('physicsAngle');
            if(angleInput){ const next=THREE.MathUtils.clamp(Number(angleInput.value)-dy*.22,10,80); angleInput.value=String(Math.round(next)); angleInput.dispatchEvent(new Event('input',{bubbles:true})); }
        } else {
            theta-=dx*.006; phi-=dy*.004; updateCamera();
        }
        prev={x:event.clientX,y:event.clientY};
    });
    const endPointer=()=>{pointerDown=false;draggingObject=null;};
    renderer.domElement.addEventListener('pointerup',endPointer); renderer.domElement.addEventListener('pointercancel',endPointer);
    renderer.domElement.addEventListener('wheel',(event)=>{radius=Math.max(5,Math.min(15,radius+event.deltaY*.008));updateCamera();},{passive:true});
    const resize=()=>{const w=container.clientWidth;const h=container.clientHeight;if(!w||!h)return;camera.aspect=w/h;camera.updateProjectionMatrix();renderer.setSize(w,h);};
    const observer=new ResizeObserver(resize);observer.observe(container);
    const clock=new THREE.Clock(); let projectileAnimation=null; let reactionStart=0; let disposed=false;
    const animate=()=>{if(disposed)return;requestAnimationFrame(animate);const t=clock.getElapsedTime();
        if(projectileAnimation){const a=projectileAnimation;const sec=Math.min(a.time,(t-a.start)*1.4);const rad=a.angle*Math.PI/180;const x=a.speed*Math.cos(rad)*sec;const y=a.speed*Math.sin(rad)*sec-.5*a.gravity*sec*sec;state.projectile.position.set(-.95+x*.33,1.97+Math.max(y*.33,-1.55),0);if(sec>=a.time){projectileAnimation=null;}}
        if(state.trajectory && type==='physics' && projectileAnimation){/* line remains visible while animation runs */}
        if(type==='chemistry'&&state.reaction){state.bubbles.forEach((b,i)=>{b.visible=true;b.position.y=1.45+((t*0.55+i*.17)%1.15);b.position.x=.65+Math.sin(t*2+i)*.2;b.material.opacity=.45+Math.sin(t*4+i)*.25;});if(t-reactionStart>7)state.reaction=false;}
        if(type==='electrical'&&state.switchOn){state.electronDots.forEach((dot,i)=>{dot.visible=true;const p=((t*.22+i/state.electronDots.length)%1);dot.position.set(-2+p*4.05,1.85+Math.sin(p*Math.PI*2)*.12,.35+Math.cos(p*Math.PI*2)*.42);});}else if(type==='electrical')state.electronDots.forEach(d=>d.visible=false);
        renderer.render(scene,camera);
    };animate();requestAnimationFrame(()=>callbacks.onReady?.());

    return {
        resize,
        cameraAction(action){if(action==='reset'){theta=Math.atan2(6.5,8.5);phi=1.02;radius=11.8;}if(action==='zoom-in')radius-=1;if(action==='zoom-out')radius+=1;updateCamera();},
        setPhysics(params){if(type!=='physics')return;const rad=params.angle*Math.PI/180;state.physicsRails?.forEach((rail)=>{rail.rotation.z=-rad;});state.projectile.position.set(-.95,1.97,0);const pts=[];const time=2*params.speed*Math.sin(rad)/params.gravity;for(let i=0;i<=45;i++){const t=time*i/45;pts.push(new THREE.Vector3(-.95+params.speed*Math.cos(rad)*t*.33,1.97+(params.speed*Math.sin(rad)*t-.5*params.gravity*t*t)*.33,0));}state.trajectory.geometry.dispose();state.trajectory.geometry=new THREE.BufferGeometry().setFromPoints(pts);state.trajectory.visible=true;},
        animateProjectile(params){if(type!=='physics')return;this.setPhysics(params);state.projectile.position.set(-.95,1.97,0);projectileAnimation={...params,start:clock.getElapsedTime()};},
        setChemistryMaterials(params){if(type!=='chemistry')return;state.beakerLiquid.scale.y=params.vinegar?Math.max(.6,params.volume/35):.01;state.beakerLiquid.visible=params.vinegar;state.beakerLiquid.material.color.set(params.vinegar?'#9bcbd4':'#d8ece7');},
        runChemistry(){if(type!=='chemistry')return;state.reaction=true;reactionStart=clock.getElapsedTime();state.beakerLiquid.material.color.set('#d5e8dc');},
        resetChemistry(){if(type!=='chemistry')return;state.reaction=false;state.beakerLiquid.visible=false;state.beakerLiquid.scale.y=1;state.bubbles.forEach(b=>b.visible=false);},
        setCircuit(params){if(type!=='electrical')return;state.switchOn=params.on;state.lampMaterial.emissive.set(params.on?'#f6d46c':'#000000');state.lampMaterial.emissiveIntensity=params.on?2.6:.1;state.lampMaterial.color.set(params.on?'#fff2c1':'#e5dfc3');},
    };
}

function addBox(scene, position, size, material, shadow=true) { const mesh=new THREE.Mesh(new THREE.BoxGeometry(...size),material);mesh.position.set(...position);mesh.castShadow=shadow;mesh.receiveShadow=true;scene.add(mesh);return mesh; }
