<template>
    <div>
        <p>{{views}}</p>
        <button @click="increase">increase</button>
        <button @click="decrease">decrease</button>

        <div v-for="(blog , i) in  blogs" :key="i">
            <h1>{{blog.title}}</h1>
            <p>{{blog.post}}</p>
        </div>

        <div>
            <h2 v-if="showItem">show this item if is true</h2>
            <h2 v-else>do not show this item if is false</h2>
            <button @click=" showItem = !showItem">return</button>
        </div>
    </div>
</template>
<script>
export default {
    data(){
        return{
            views:0,
            blogs:[],
            showItem:false
        }
    },
    methods:{
        increase(){
            this.counter++;
        },
        decrease(){
            this.counter--;
        },
        showItemfun(){
            this.showItem = !this.showItem ;
        }
    },
    created(){
        this.views=100;
        let posts=[
            { title:'this is the title' , post:'sjbvsjkd slkdnhdslk sldkjskl dksk ;sdfjs;' , id:1 },
            { title:'this is the title' , post:'sjbvsjkd slkdnhdslk sldkjskl dksk ;sdfjs;' , id:2 },
            { title:'this is the title' , post:'sjbvsjkd slkdnhdslk sldkjskl dksk ;sdfjs;' , id:3 },
            { title:'this is the title' , post:'sjbvsjkd slkdnhdslk sldkjskl dksk ;sdfjs;' , id:4 },
        ];
        this.blogs=posts;
        console.log(this.blogs);
    }
}
</script>
