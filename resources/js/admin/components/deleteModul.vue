<template>
    <div>
        <!--~~~~~~~ category delete model ~~~~~~~~~-->
        <Modal :value="getDeleteObj.showDeleteModul"
            :mask-closable="false"

            width="360">
            <p slot="header" style="color:#f60;text-align:center">
                <Icon type="ios-information-circle"></Icon>
                <span>Delete confirmation</span>
            </p>
            <div style="text-align:center">
                <p>Are you sure you want to delete this item ?</p>
            </div>
            <div slot="footer">
                <Button type="error" size="large" long :loadind="getDeleteInf.isDeleting"  :disabled="getDeleteInf.isDeleting" @click="deleteM()">Delete</Button>
            </div>
            <div slot="close">
                <Icon type="ios-close" @click="close"/>
            </div>
        </Modal>
        <!--- <Modal
            v-model="deleteModel"
            title="delete category"
            :mask-closable="false"
            :closable="false"
            >
            <p>Did You really want to delete this ?</p>

            <div slot="footer">
                <Button type="default" @click="deleteModel = false ;data.categoryName=''">Close</Button>
                <Button type="primary" @click="deleteCategory" :disabled="isDeleting" :loading="isDeleting">{{isDeleting ? 'Deleting...' : 'Delete category'}}</Button>
            </div>
        </Modal>-->


        <!--~~~~~~~end  category delete model~~~~~~-->

    </div>
</template>

<script>

import {mapGetters} from 'vuex';

export default {
   // name:"DeleteModul",
    data(){
        return{
           // isDeleting:false
        }
    },
    computed:{
        ... mapGetters(['getDeleteObj','getDeleteInf']),
    },
    methods:{
        close(){
            this.$store.commit('setDeleteModul',false);
            this.$store.commit('setDeleteInf',{isDeleting:false,deletingIndex:-1});

        },
        async deleteM(){
            //console.log(getDeleteObj);
            //let deleteInf;
            //this.isDeleting=true;
            const res=await this.callApi('post',this.getDeleteObj.deleteUrl,this.getDeleteObj.data);
            //console.log(res);
            if(res.data==0){
                this.w('Item  is Not Found');
            }else{
                    if(res.status===200 ){
                        //this.isDeleting=false;
                        //console.log(this.getDeleteObj.deletingIndex);
                       // getContents.splice(this.getDeleteObj.deletingIndex,1);
                        /* deleteInf={
                           isDeleting:true,
                           deletingIndex:this.getDeleteObj.deletingIndex
                       }*/
                       console.log()
                        this.s('Item is deleted correctly');
                        this.$store.commit('setDeleteModul',false);
                        this.$store.commit('setDeleteInf',{isDeleting:true,deletingIndex:this.getDeleteInf.deletingIndex});
                        //this.$store.commit('reset','');
                    }else{
                        this.swr();
                       /* deleteInf={
                           isDeleting:false,
                           deletingIndex:null
                       }*/
                        this.$store.commit('setDeleteModul',true);
                        this.$store.commit('setDeleteInf',{isDeleting:false,deletingIndex:this.getDeleteInf.deletingIndex});
                    }
                   // getDeleteObj.showDeleteModul=true;
            }

        },

    }
}
</script>
