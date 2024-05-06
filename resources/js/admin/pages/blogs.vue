<template>
    <div>
       <div class="content">
			<div class="container-fluid">

				<!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
				<div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
					<p class="_title0">Blogs <Button @click="$router.push('/createBlog')" v-if="isWritePermitted"><Icon type="md-add" />  Create Blog</Button> </p>

					<div class="_overflow _table_div">
						<table class="_table">
								<!-- TABLE TITLE -->
							<tr>
								<th>ID</th>
								<th>Title</th>
                                <th>Categories</th>
                                <th>Tags</th>
                                <th>Views</th>
								<th>Created at</th>
								<th>Action</th>
							</tr>
								<!-- TABLE TITLE -->


								<!-- ITEMS -->
							<tr v-for="(blog , i) in blogs " :key="i">
								<td>{{blog.id}}</td>
								<td class="_table_name">{{blog.title}}</td>
                                <td><span  v-for="(c , j) in blog.cate" :key="j" v-if="blog.cate.length"><Tag color="default">{{c.categoryName}}</Tag></br></span></td>
                                <td><span  v-for="(t , j) in blog.tag"  :key="j" v-if="blog.tag.length"><Tag color="default">{{t.tagName}}</Tag></br></span></td>
                                <td >{{blog.views}}</td>
								<td>{{blog.created_at}}</td>
								<td>
                                    <Button type="info" size="small">Visit blog</Button>
									<Button type="error" size="small" @click="$router.push(`/editBlog/${blog.id}`)" v-if="isUpdatePermitted">Edit</Button>
									<Button type="info" size="small" @click="/*showDeleteModel(tag,i)*/showDeleteModel(blog,i)" v-if="isDeletePermitted">Delete</Button>
								</td>
							</tr>

						</table>
					</div>





                <!--~~~~~~~ tag delete model ~~~~~~~~~-->
                     <deleteModul ></deleteModul>




                <!--~~~~~~~end  tag delete model~~~~~~-->
				</div>

			</div>
		</div>
    </div>
</template>
<script>


import deleteModul from '../components/deleteModul.vue'
import {mapGetters} from 'vuex';

export default {
   data(){
       return{
           blogs:[],
           index:-1,
       }
   },
   components:{
       deleteModul
   },
   methods:{

       showDeleteModel(blog,index){
           const deleteModulObj={
            showDeleteModul:true,
            deleteUrl:'/blog/delete_blog',
            data:blog,
        };
        //console.log(deleteModulObj)
        this.$store.commit('setDeletingModulObj',deleteModulObj);
        //this.$store.commit('setDeleteModul',deleteModulObj,false);
        this.$store.commit('setDeleteModul',true);
        this.$store.commit('setDeleteInf',{isDeleting:false,deletingIndex:index});
        //console.log(deleteModulObj);
        //console.log(this.getDeleteObj);
        //console.log(this.getDeleteInf);
           //this.deletedata=tag;
           //this.deleteModel=true;
           //this.index=index;
       }

   },
   async created(){
       //console.log("user permission is :",this.isWritePermitted);
       const res=await this.callApi('get','/blog/get_blogs');
       if(res.status === 200){
           this.blogs=res.data;
       }else{
           this.swr();
       }

    },
    computed:{
        ...mapGetters(['getDeleteObj','getDeleteInf'])
    },
    watch:{
        /*getDeleteObj(obj){
            console.log(obj);
            console.log(this.getDeleteInf.isDeleting);
            if(this.getDeleteInf.isDeleting){
                console.log('in side if');
                this.tags.splice(this.getDeleteInf.deletingIndex,1);
            }
        },*/
        getDeleteInf(obj){
            console.log(obj);
            //console.log(obj.isDeleting);
            if(obj.isDeleting){
                console.log('in side if');
                this.blogs.splice(obj.deletingIndex,1);
            }
        }
    }

}
</script>


