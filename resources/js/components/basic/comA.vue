<template>
    <div class="content">
        <div class="container-fluid">
            <p>This is app for Vuex</p>
            <p>{{$store.state.counter}}</p>
        </div>
    </div>
</template>
<script>
export default {
    computed:{
        getCounter(){

        }
    },
}
</script>
