import { BloomEffect,
         GlitchEffect,
         SepiaEffect,
         EffectComposer,
         EffectPass,
         RenderPass } from "postprocessing";


export const postprocessingSystem = {

    composer: null,
    originalRenderMethod: null,

    /**
     * Initializes this system.
     */

    init() {

	const sceneEl = this.sceneEl;
	const scene = sceneEl.object3D;
	const renderer = sceneEl.renderer;
	const render = renderer.render;
	const camera = sceneEl.camera;

	const composer = new EffectComposer(renderer);
	this.composer = composer;
	this.originalRenderMethod = render;

//	const smaaEffect = new SMAAEffect();
//	const noiseEffect = new NoiseEffect();
	const sepiaEffect = new SepiaEffect();
//	const vignetteEffect = new VignetteEffect();
        const bloomEffect = new BloomEffect();
	const glitchEffect = new GlitchEffect();

	//noiseEffect.blendMode.opacity.value = 0.6;
	sepiaEffect.blendMode.opacity.value = 0.3;

	const renderPass = new RenderPass(scene, camera);
	const effectPass = new EffectPass(
	    camera,
	    //smaaEffect,
	    //noiseEffect,
	    //sepiaEffect,
	    //vignetteEffect,
            //glitchEffect,
            //bloomEffect,
	);

	composer.addPass(renderPass);
	composer.addPass(effectPass);

	// Hijack the render method.
	let calledByComposer = false;

	renderer.render = function() {

	    if(calledByComposer) {

		render.apply(renderer, arguments);

	    } else {

		calledByComposer = true;
		composer.render();
		calledByComposer = false;

	    }

	};

    },

    /**
     * Clean up when the system gets removed.
     */

    remove() {

	this.composer.renderer.render = this.originalRenderMethod;
	this.composer.dispose();

    }

};
