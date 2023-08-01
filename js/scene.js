import * as THREE from 'three';

import { TrackballControls } from 'three/addons/controls/TrackballControls.js';

import { Perlin } from 'three-noise';

let perspectiveCamera, orthographicCamera, controls, scene, renderer;

const params = {
    orthographicCamera: false
};

const frustumSize = 400;

const state = {
    category: 3,
    posts: [],
    perlin: new Perlin(0.3)
};


async function initTrollfield(evt) {
    console.log("HERE WE GO");

    state.posts = await fetch(`${window.wpData.rest_url}/wp/v2/posts`)
        .then(d => d.json())
        .then(d => d);

    console.log(state.posts);

    init();
    animate();
}

//init();
//animate();

function init() {

    const aspect = window.innerWidth / window.innerHeight;

    perspectiveCamera = new THREE.PerspectiveCamera( 60, aspect, 1, 1000 );
    perspectiveCamera.position.z = 500;

    orthographicCamera = new THREE.OrthographicCamera( frustumSize * aspect / - 2, frustumSize * aspect / 2, frustumSize / 2, frustumSize / - 2, 1, 1000 );
    orthographicCamera.position.z = 500;

    // world

    scene = new THREE.Scene();
    scene.background = new THREE.Color( 0xcccccc );
    scene.fog = new THREE.FogExp2( 0xcccccc, 0.002 );

    const geometry = new THREE.ConeGeometry( 10, 30, 4, 1 );
    const material = new THREE.MeshPhongMaterial( { color: 0xffffff, flatShading: true } );


    // Geometries for every post
    state.posts.forEach((item, key) => {
	const mesh = new THREE.Mesh( geometry, material );
        let v1 = new THREE.Vector3(0.4, key + 0.0035);
        let v2 = new THREE.Vector3(304, key + 0.003);
        let v3 = new THREE.Vector3(24, key + 0.003);
        let n1 = state.perlin.get2(v1);
        let n2 = state.perlin.get2(v2);
        let n3 = state.perlin.get2(v3);
        console.log(n1, n2);

	mesh.position.x = (n1 + 1) * 100;
	mesh.position.y = (n2 + 1) * 100;
        mesh.position.z = (n3 + 1) * 100;
	mesh.updateMatrix();
	mesh.matrixAutoUpdate = false;
	scene.add( mesh );

    });

    // lights

    const dirLight1 = new THREE.DirectionalLight( 0xffffff, 3 );
    dirLight1.position.set( 1, 1, 1 );
    scene.add( dirLight1 );

    const dirLight2 = new THREE.DirectionalLight( 0x002288, 3 );
    dirLight2.position.set( - 1, - 1, - 1 );
    scene.add( dirLight2 );

    const ambientLight = new THREE.AmbientLight( 0x555555 );
    scene.add( ambientLight );

    // renderer

    renderer = new THREE.WebGLRenderer( { antialias: true } );
    renderer.setPixelRatio( window.devicePixelRatio );
    renderer.setSize( window.innerWidth, window.innerHeight );
    document.body.appendChild( renderer.domElement );

    window.addEventListener( 'resize', onWindowResize );

    createControls( perspectiveCamera );

}

function createControls( camera ) {

    controls = new TrackballControls( camera, renderer.domElement );

    controls.rotateSpeed = 1.0;
    controls.zoomSpeed = 1.2;
    controls.panSpeed = 0.8;

    controls.keys = [ 'KeyA', 'KeyS', 'KeyD' ];

}

function onWindowResize() {

    const aspect = window.innerWidth / window.innerHeight;

    perspectiveCamera.aspect = aspect;
    perspectiveCamera.updateProjectionMatrix();

    orthographicCamera.left = - frustumSize * aspect / 2;
    orthographicCamera.right = frustumSize * aspect / 2;
    orthographicCamera.top = frustumSize / 2;
    orthographicCamera.bottom = - frustumSize / 2;
    orthographicCamera.updateProjectionMatrix();

    renderer.setSize( window.innerWidth, window.innerHeight );

    controls.handleResize();

}

function animate() {

    requestAnimationFrame( animate );

    controls.update();

    render();

}

function render() {

    const camera = ( params.orthographicCamera ) ? orthographicCamera : perspectiveCamera;

    renderer.render( scene, camera );

}

document.addEventListener('DOMContentLoaded', initTrollfield);
