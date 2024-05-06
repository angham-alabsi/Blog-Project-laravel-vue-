<template>
    <div>
       <div class="content">
			<div class="container-fluid">

				<!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
				<div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
					<p class="_title0">Role Management <Button @click="addModel=true" v-if="isWritePermitted"><Icon type="md-add" />  Add new role</Button> </p>

					<div class="_overflow _table_div">
						<table class="_table">
								<!-- TABLE TITLE -->
							<tr>
								<th>ID</th>
								<th>Role name</th>
								<th>Created at</th>
								<th>Action</th>
							</tr>
								<!-- TABLE TITLE -->


								<!-- ITEMS -->
							<tr v-for="(role , i) in roles " :key="i">
								<td>{{role.id}}</td>
								<td class="_table_name">{{role.roleName}}</td>
								<td>{{role.created_at}}</td>
								<td>
									<Button type="error" size="small" @click="showEditModel(role,i)" v-if="isUpdatePermitted">Edit</Button>
									<Button type="info" size="small" @click="/*showDeleteModel(role,i)*/showDeleteModel(role,i)" v-if="isDeletePermitted">Delete</Button>
								</td>
							</tr>

						</table>
					</div>

                <!--~~~~~~~ role add model ~~~~~~~~~-->

                        <Modal
                            v-model="addModel"
                            title="Add role"
                            :mask-closable="false"
                            :closable="false"
                            >
                            <Input v-model="data.roleName" placeholder="Add role name" />

                            <div slot="footer">
                                <Button type="default" @click="addModel = false ;data.roleName=''">Close</Button>
                                <Button type="primary" @click="addRole" :disabled="isAdding" :loading="isAdding">{{isAdding ? 'Adding...' : 'Add role'}}</Button>
                            </div>
                        </Modal>


                <!--~~~~~~~end  role add model~~~~~~-->

                <!--~~~~~~~ role edit model ~~~~~~~~~-->

                        <Modal
                            v-model="editModel"
                            title="Edit role"
                            :mask-closable="false"
                            :closable="false"
                            >
                            <Input v-model="editdata.roleName" placeholder="Edit role name" />

                            <div slot="footer">
                                <Button type="default" @click="editModel = false ;data.roleName=''">Close</Button>
                                <Button type="primary" @click="editRole" :disabled="isEditting" :loading="isEditting">{{isEditting ? 'Editting...' : 'Edit role'}}</Button>
                            </div>
                        </Modal>


                <!--~~~~~~~end  role edit model~~~~~~-->

                <!--~~~~~~~ role delete model ~~~~~~~~~-->
                     <deleteModul ></deleteModul>
                       <!--- <Modal v-model="deleteModel" width="360">
                            <p slot="header" style="color:#f60;text-align:center">
                                <Icon type="ios-information-circle"></Icon>
                                <span>Delete confirmation</span>
                            </p>
                            <div style="text-align:center">
                                <p>Are you sure you want to delete this role ?</p>
                            </div>
                            <div slot="footer">
                                <Button type="error" size="large" long  @click="deleteRole()">Delete</Button>
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
               roleName:'',
           },
           editdata:{
               roleName:'',
           },
           //deletedata:"",
           addModel:false,
           editModel:false,
           //deleteModel:false,
           isAdding:false,
           isEditting:false,
           //isDeleting:false,
           roles:[],
           index:-1,
       }
   },
   components:{
       deleteModul
   },
   methods:{
       async addRole(){
           if(this.data.roleName.trim()==""){
              return this.e('Role name is required');
           }else{
               const res=await this.callApi('post','/role/create_role',this.data);
               if(res.status===201 ){
                   this.isAdding=true;
                   this.roles.unshift(res.data);
                   this.s('Role name is inserted correctly');
                   this.addModel=false;
                   this.data.roleName="";
                   this.isAdding=false;
               }else{
                   if(res.status===422) {
                        if(res.data.errors.roleName){
                            this.e(res.data.errors.roleName[0]);
                        } else {
                                this.swr();
                        }
                   }
               }

           }
       },

        async editRole(){
           if(this.editdata.roleName.trim()==""){
              return this.e('Role name is required');
           }else{
               const res=await this.callApi('post','/role/edit_role',this.editdata);
               if(res.status===200 ){
                   this.isEditting=true;
                   this.roles[this.index].roleName=this.editdata.roleName;
                   this.s('Role name is edited correctly');
                   this.editModel=false;
                   this.data.roleName="";
                   this.isEditting=false;
               }else{
                   if(res.status===422) {
                        if(res.data.errors.roleName){
                            this.e(res.data.errors.roleName[0]);
                        } else {
                                this.swr();
                        }
                   }
               }

           }
       },
       showEditModel(role , index){
           let obj={
               id:role.id,
               roleName:role.roleName
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

       showDeleteModel(role,index){
           const deleteModulObj={
            showDeleteModul:true,
            deleteUrl:'/role/dalate_role',
            data:role,
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
       const res=await this.callApi('get','/role/get_roles');
       if(res.status === 200){
           this.roles=res.data;
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
                this.roles.splice(obj.deletingIndex,1);
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
