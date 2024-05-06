<template>
    <div>
       <div class="content">
			<div class="container-fluid">

				<!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
				<div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
					<p class="_title0">Users <Button @click="addModel=true"  v-if="isWritePermitted" ><Icon type="md-add" />  Add user</Button> </p>

					<div class="_overflow _table_div">
						<table class="_table">
								<!-- TABLE TITLE -->
							<tr>
								<th>ID</th>
								<th>User name</th>
                                <th>Email</th>
                                <th>Role</th>
								<th>Created at</th>
								<th>Action</th>
							</tr>
								<!-- TABLE TITLE -->


								<!-- ITEMS -->
							<tr v-for="(user , i) in users " :key="i">
								<td>{{user.id}}</td>
								<td class="_table_name">{{user.fullname}}</td>
                                <td>{{user.email}}</td>
                                <td>{{user.role.roleName}}</td>
								<td>{{user.created_at}}</td>
								<td>
									<Button type="error" size="small" @click="showEditModel(user,i)" v-if="isUpdatePermitted">Edit</Button>
									<Button type="info" size="small" @click="/*showDeleteModel(user,i)*/showDeleteModel(user,i)" v-if="isDeletePermitted">Delete</Button>
								</td>
							</tr>

						</table>
					</div>

                <!--~~~~~~~ user add model ~~~~~~~~~-->

                        <Modal
                            v-model="addModel"
                            title="Add user"
                            :mask-closable="false"
                            :closable="false"
                            >
                            <div class="space"><Input v-model="data.fullname" placeholder="Add full name" /></div>
                            <div class="space"><Input v-model="data.email" placeholder="Add  email" /></div>
                            <div class="space"><Input type="password" :password="true" v-model="data.password" placeholder="Add password" /></div>
                            <div class="space">
                                <Select v-model="data.role_id" width="400px" placeholder="Select user type">
                                    <Option  v-for="(role,i) in roles" :key="i"  :value="role.id">{{role.roleName}}</Option>
                                </Select>
                            </div>

                            <div slot="footer">
                                <Button type="default" @click="addModel = false ;data.fullname='';data.email='';data.password='';data.role_id=''">Close</Button>
                                <Button type="primary" @click="addUser" :disabled="isAdding" :loading="isAdding">{{isAdding ? 'Adding...' : 'Add user'}}</Button>
                            </div>
                        </Modal>


                <!--~~~~~~~end  user add model~~~~~~-->

                <!--~~~~~~~ user edit model ~~~~~~~~~-->

                        <Modal
                            v-model="editModel"
                            title="Edit user"
                            :mask-closable="false"
                            :closable="false"
                            >
                            <div class="space"><Input v-model="editdata.fullname" placeholder="Add full name" /></div>
                            <div class="space"><Input type="email" v-model="editdata.email" placeholder="Add  email" /></div>
                            <div class="space"><Input type="password"  v-model="editdata.password" placeholder="Add password" /></div>
                            <div class="space">
                                <Select v-model="editdata.role_id" width="400px" placeholder="Select user type">
                                    <Option  v-for="(role,i) in roles" :key="i" :value="role.id" >{{role.roleName}}</Option>
                                </Select>
                            </div>

                            <div slot="footer">
                                <Button type="default" @click="editModel = false ;editdata.fullname='';editdata.email='';editdata.password='';editdata.role_id=''">Close</Button>
                                <Button type="primary" @click="editUser" :disabled="isEditting" :loading="isEditting">{{isEditting ? 'Editting...' : 'Edit user'}}</Button>
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
               fullname:'',
               email:'',
               password:'',
               role_id:null,
           },
           editdata:{
               fullname:'',
               email:'',
               password:'',
               role_id:null,
           },
           //deletedata:"",
           addModel:false,
           editModel:false,
           //deleteModel:false,
           isAdding:false,
           isEditting:false,
           //isDeleting:false,
           users:[],
           roles:[],
           index:-1,
       }
   },
   components:{
       deleteModul
   },
   methods:{
       async addUser(){

            if(this.data.fullname.trim()==""){ return this.e('The user name is required');}
            if(this.data.email.trim()==""){ return this.e('Email  is required');}
            if(this.data.password.trim()==""){ return this.e('password is required');}
            if(!this.data.role_id){ return this.e('User type is required');}

            else{
                console.log("role :",this.data.role_id);
               const res=await this.callApi('post','/user/create_user',this.data);
                console.log(res);
               if(res.status===201 ){
                   this.isAdding=true;
                   this.users.unshift(res.data);
                   this.s('The user is inserted correctly');
                   this.addModel=false;
                   this.data.fullname="";
                   this.data.email="";
                   this.data.password="";
                   this.data.role_id="";
                   this.isAdding=false;
               }else{
                   //console.log(res);
                   if(res.status===422) {
                       for(let i in res.data.errors){
                           this.e(res.data.errors[i][0]);
                       }
                   }else{
                            this.swr();
                        }
               }

           }
       },

        async editUser(){
            if(this.editdata.fullname.trim()==""){ return this.e('The user name is required');}
            if(this.editdata.email.trim()==""){ return this.e('Email  is required');}
            if(this.editdata.password.trim()==""){ return this.e('password is required');}
            if(!this.editdata.role_id){ return this.e('User type is required');}
            else{
               const res=await this.callApi('post','/user/edit_user',this.editdata);
               if(res.status===200 ){
                   this.isEditting=true;
                   this.users[this.index].fullname=this.editdata.fullname;
                   this.users[this.index].role_id=this.editdata.role_id;
                   this.users[this.index].email=this.editdata.email;
                   this.s('The user is edited correctly');
                   this.editModel=false;
                    this.editdata.fullname="";
                   this.editdata.email="";
                   this.editdata.password="";
                   this.editdata.role_id="";
                   this.isEditting=false;
               }else{
                   if(res.status===422) {
                        for(let i in res.data.errors){
                            this.e(res.data.errors[i][0]);
                        }
                   }else {
                                this.swr();
                        }
               }

           }
       },
       showEditModel(user , index){
           let obj={
               id:user.id,
               fullname:user.fullname,
               email:user.email,
               password:'',
               role_id:user.role_id,
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
       const [res,resRole]=await Promise.all([
           this.callApi('get','/user/get_users'),
           this.callApi('get','/role/get_roles'),
       ]);
      // const res=await this.callApi('get','/user/get_users');
       if(res.status === 200){
           this.users=res.data;
       }else{
           this.swr();
       }
        if(resRole.status === 200){
           this.roles=resRole.data;
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
