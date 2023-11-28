AFRAME.registerComponent('cursor-listener', {
    init() {
        this.el.addEventListener('click', function (evt) {
            let slug = evt.target.attributes['post-url'];
            if (slug) {
                window.vueRouter.push(`/${slug.value}`);
            }
        });
    }
});
