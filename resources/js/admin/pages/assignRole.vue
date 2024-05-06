<template>
    <div>
       <div class="content">
			<div class="container-fluid">

				<!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
				<div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
					<p class="_title0">Role Permissions Management
                        <Select v-model="data.id" width="400px" placeholder="Select user type" style="width:300px" @on-change="changeRole">
                            <Option  v-for="(role,i) in roles" :key="i"  :value="role.id">{{role.roleName}}</Option>
                        </Select> </p>

					<div class="_overflow _table_div">
						<table class="_table">
								<!-- TABLE TITLE -->
							<tr>
								<th>Resource name</th>
								<th>Read</th>
								<th>Write</th>
								<th>Update</th>
                                <th>Delete</th>
							</tr>
								<!-- TABLE TITLE -->


								<!-- ITEMS -->
							<tr v-for="(role,i ) in resources " :key="i">
								<td class="_table_name">{{role.resourceName}}</td>
                                <td><Checkbox v-model="role.read"></Checkbox></td>
                                <td><Checkbox v-model="role.write"></Checkbox></td>
                                <td><Checkbox v-model="role.update"></Checkbox></td>
                                <td><Checkbox v-model="role.delete"></Checkbox></td>
							</tr>

						</table>
                        <div>
                            <Button type="info" style="margin: 0px auto; display: block; margin-top: 20px;" @click="assignRole" :loading="isSending" :disabled="isSending" >{{isSending?"is assign ":"Assign"}}</Button>
                        </div>
					</div>
				</div>
			</div>
		</div>
    </div>
</template>
<script>


export default {
   data(){
       return{
           data:{
               id:null,
               roleName:'',
           },
           roles:[],

           resources:[
               {resourceName:'Home'        , delete:false , write:false , read:false , update:false , name:'/'},
               {resourceName:'Tags'        , delete:false , write:false , read:false , update:false , name:'tags'},
               {resourceName:'Categories'  , delete:false , write:false , read:false , update:false , name:'categories'},
               {resourceName:'Create Blog' , delete:false , write:false , read:false , update:false , name:'createBlog'},
               {resourceName:'Blogs'       , delete:false , write:false , read:false , update:false , name:'blogs'},
               {resourceName:'Admin'       , delete:false , write:false , read:false , update:false , name:'admin'},
               {resourceName:'Login'       , delete:false , write:false , read:false , update:false , name:'login'},
               {resourceName:'Roles'       , delete:false , write:false , read:false , update:false , name:'roles'},
               {resourceName:'Assign Role' , delete:false , write:false , read:false , update:false , name:'assignRole'},
           ],

            resourcesDefault:[
               {resourceName:'Home'        , delete:false , write:false , read:false , update:false , name:'/'},
               {resourceName:'Tags'        , delete:false , write:false , read:false , update:false , name:'tags'},
               {resourceName:'Categories'  , delete:false , write:false , read:false , update:false , name:'categories'},
               {resourceName:'Create Blog' , delete:false , write:false , read:false , update:false , name:'createBlog'},
               {resourceName:'Blogs'       , delete:false , write:false , read:false , update:false , name:'blogs'},
               {resourceName:'Admin'       , delete:false , write:false , read:false , update:false , name:'admin'},
               {resourceName:'Login'       , delete:false , write:false , read:false , update:false , name:'login'},
               {resourceName:'Roles'       , delete:false , write:false , read:false , update:false , name:'roles'},
               {resourceName:'Assign Role' , delete:false , write:false , read:false , update:false , name:'assignRole'},

           ],

           isSending:false,
       }
   },

   methods:{

       changeRole(){
           //console.log(this.data.id);
           let index=this.roles.findIndex(role=>role.id == this.data.id)
           console.log(this.roles);
           if(this.roles[index].permission){
                this.resources=JSON.parse(this.roles[index].permission);
                //console.log(this.resources);
           }else{
               this.resources=this.resourcesDefault;
           }

       },

       async assignRole(){
           let data=JSON.stringify(this.resources);
            const res=await this.callApi('post','/role/assign_role',{permission:data , id:this.data.id});
            if(res.status==200){
                this.s('Permissions are inserted sucessfully');
                console.log(res.data);
                //this.roles=res.data;
                let index=this.roles.findIndex(role=>role.id == this.data.id)
                 this.roles[index].permission = data

                //this.resources=JSON.parse(res.data[index].permission);
                //this.resources=JSON.parse(this.roles[index].permission);
                //console.log(this.roles[2].permission);
            }else{
                this.swr();
            }
       },

   },

   async created(){
       console.log(this.$route);
       const res=await this.callApi('get','/role/get_roles');
       if(res.status === 200){
           this.roles=res.data;
           if(res.data.length){
               this.data.id=res.data[0].id;
               if(res.data[0].permission){

                   this.resources=JSON.parse(res.data[0].permission);
                   //this.resources=this.resourcesDefault;
               }
           }
       }else{
           this.swr();
       }

    },

}
</script>

