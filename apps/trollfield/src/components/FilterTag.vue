<template>
    <li><button class="filter-tag">{{ tag.name }}</button></li>
</template>
<script>
 export default {
     name: "FilterTag",
     props: ['tag']
 }
</script>
