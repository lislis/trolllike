<template>
    <Box :position="position"
         @pointerOver="onPointerOver"
         @click="onPointerClick">
        <PhongMaterial :color="materialColor" />
    </Box>
</template>
<script>
export default {
     name: "GeomPost",
     props: [ 'key', 'post' ],
     data() {
         return {
             materialColor: '#dd0000',
         }
     },
     methods: {
         onPointerOver({over}) {
             this.materialColor = over ? '#00ff00' : '#ff0000';
         },
         onPointerClick(e) {
             console.log(e);
         }
     },
     computed: {
         position() {
             return {x: this.key + 1 , y: this.key + 1, z: -5 };
         }
     }
}
</script>
