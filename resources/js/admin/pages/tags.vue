<template>
    <div>
       <div class="content">
			<div class="container-fluid">

				<!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
				<div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
					<p class="_title0">Tags <Button @click="addModel=true" v-if="isWritePermitted"><Icon type="md-add" />  Add tag</Button> </p>

					<div class="_overflow _table_div">
						<table class="_table">
								<!-- TABLE TITLE -->
							<tr>
								<th>ID</th>
								<th>Tag name</th>
								<th>Created at</th>
								<th>Action</th>
							</tr>
								<!-- TABLE TITLE -->


								<!-- ITEMS -->
							<tr v-for="(tag , i) in tags " :key="i">
								<td>{{tag.id}}</td>
								<td class="_table_name">{{tag.tagName}}</td>
								<td>{{tag.created_at}}</td>
								<td>
									<Button type="error" size="small" @click="showEditModel(tag,i)" v-if="isUpdatePermitted">Edit</Button>
									<Button type="info" size="small" @click="/*showDeleteModel(tag,i)*/showDeleteModel(tag,i)" v-if="isDeletePermitted">Delete</Button>
								</td>
							</tr>

						</table>
					</div>

                <!--~~~~~~~ tag add model ~~~~~~~~~-->

                        <Modal
                            v-model="addModel"
                            title="Add tag"
                            :mask-closable="false"
                            :closable="false"
                            >
                            <Input v-model="data.tagName" placeholder="Add tag name" />

                            <div slot="footer">
                                <Button type="default" @click="addModel = false ;data.tagName=''">Close</Button>
                                <Button type="primary" @click="addTag" :disabled="isAdding" :loading="isAdding">{{isAdding ? 'Adding...' : 'Add tag'}}</Button>
                            </div>
                        </Modal>


                <!--~~~~~~~end  tag add model~~~~~~-->

                <!--~~~~~~~ tag edit model ~~~~~~~~~-->

                        <Modal
                            v-model="editModel"
                            title="Edit tag"
                            :mask-closable="false"
                            :closable="false"
                            >
                            <Input v-model="editdata.tagName" placeholder="Edit tag name" />

                            <div slot="footer">
                                <Button type="default" @click="editModel = false ;data.tagName=''">Close</Button>
                                <Button type="primary" @click="editTag" :disabled="isEditting" :loading="isEditting">{{isEditting ? 'Editting...' : 'Edit tag'}}</Button>
                            </div>
                        </Modal>


                <!--~~~~~~~end  tag edit model~~~~~~-->

                <!--~~~~~~~ tag delete model ~~~~~~~~~-->
                     <deleteModul ></deleteModul>
                       <!--- <Modal v-model="deleteModel" width="360">
                            <p slot="header" style="color:#f60;text-align:center">
                                <Icon type="ios-information-circle"></Icon>
                                <span>Delete confirmation</span>
                            </p>
                            <div style="text-align:center">
                                <p>Are you sure you want to delete this tag ?</p>
                            </div>
                            <div slot="footer">
                                <Button type="error" size="large" long  @click="deleteTag()">Delete</Button>
                            </div>
                        </Modal>
                         <Modal
                            v-model="deleteModel"
                            title="delete tag"
                            :mask-closable="false"
                            :closable="false"
                            >
                            <p>Did You really want to delete this ?</p>

                            <div slot="footer">
                                <Button type="default" @click="deleteModel = false ;data.tagName=''">Close</Button>
                                <Button type="primary" @click="deleteTag" :disabled="isDeleting" :loading="isDeleting">{{isDeleting ? 'Deleting...' : 'Delete tag'}}</Button>
                            </div>
                        </Modal>-->


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
           data:{
               tagName:'',
           },
           editdata:{
               tagName:'',
           },
           //deletedata:"",
           addModel:false,
           editModel:false,
           //deleteModel:false,
           isAdding:false,
           isEditting:false,
           //isDeleting:false,
           tags:[],
           index:-1,
       }
   },
   components:{
       deleteModul
   },
   methods:{
       async addTag(){
           if(this.data.tagName.trim()==""){
              return this.e('Tag name is required');
           }else{
               const res=await this.callApi('post','/tag/create_tag',this.data);
               if(res.status===201 ){
                   this.isAdding=true;
                   this.tags.unshift(res.data);
                   this.s('Tag name is inserted correctly');
                   this.addModel=false;
                   this.data.tagName="";
                   this.isAdding=false;
               }else{
                   if(res.status===422) {
                        if(res.data.errors.tagName){
                            this.e(res.data.errors.tagName[0]);
                        } else {
                                this.swr();
                        }
                   }
               }

           }
       },

        async editTag(){
           if(this.editdata.tagName.trim()==""){
              return this.e('Tag name is required');
           }else{
               const res=await this.callApi('post','/tag/edit_tag',this.editdata);
               if(res.status===200 ){
                   this.isEditting=true;
                   this.tags[this.index].tagName=this.editdata.tagName;
                   this.s('Tag name is edited correctly');
                   this.editModel=false;
                   this.data.tagName="";
                   this.isEditting=false;
               }else{
                   if(res.status===422) {
                        if(res.data.errors.tagName){
                            this.e(res.data.errors.tagName[0]);
                        } else {
                                this.swr();
                        }
                   }
               }

           }
       },
       showEditModel(tag , index){
           let obj={
               id:tag.id,
               tagName:tag.tagName
           };
           this.editdata=obj;
           this.editModel=true;
           this.index=index;
       },

       /*async deleteTag(){
            const res=await this.callApi('post','/tag/dalate_tag',this.deletedata);
            //console.log(res);
            if(res.data==0){
                this.w('Tag name is Not Found');
            }else{
                    if(res.status===200 ){
                        //this.isDeleting=false;
                        this.tags.splice(this.index,1);
                        this.s('Tag name is deleted correctly');
                        this.deleteModel=false;
                    }else{
                        this.swr();
                    }
            }

       },*/

        /*async deleteTag(){
           if(false){
              return this.e('Tag name is required');
           }else{
               const res=await this.callApi('post','/tag/dalate_tag',this.deletedata);
               if(res.status===200 ){
                   this.isDeleting=true;
                   this.tags.splice(this.index,1);
                   this.s('Tag name is deleted correctly');
                   this.deleteModel=false;
                   this.isDeleting=false;
               }else{
                   this.swr();
               }

           }
       },*/

       showDeleteModel(tag,index){
           const deleteModulObj={
            showDeleteModul:true,
            deleteUrl:'/tag/dalate_tag',
            data:tag,
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
       const res=await this.callApi('get','/tag/get_tags');
       if(res.status === 200){
           this.tags=res.data;
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
                this.tags.splice(obj.deletingIndex,1);
            }
        }
    }

}
</script>


<!--- async created(){
        const res=await this.callApi('post','/app/create_tag',{tagName:"testtag"});
        //console.log(res);
        if(res.status==200){
            console.log(res);
        }else{
            console.log(res,"failed");
        }
    }-->
