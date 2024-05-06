<template>
    <div>
        <div class="content">
            <div class="container-fluid">
                <!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
                <div
                    class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20"
                >
                    <p class="_title0">
                        Categories
                        <Button @click="addModel = true" v-if="isWritePermitted"
                            ><Icon type="md-add"  /> Add category</Button
                        >
                    </p>

                    <div class="_overflow _table_div">
                        <table class="_table">
                            <!-- TABLE TITLE -->
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Category name</th>
                                <th>Created at</th>
                                <th>Action</th>
                            </tr>
                            <!-- TABLE TITLE -->

                            <!-- ITEMS -->
                            <tr v-for="(category, i) in categories" :key="i">
                                <td>{{ category.id }}</td>
                                <td class="table_image">
                                    <img :src="category.iconImage" />
                                </td>
                                <td class="_table_name">
                                    {{ category.categoryName }}
                                </td>
                                <td>{{ category.created_at }}</td>
                                <td>
                                    <Button
                                        type="info"
                                        size="small"
                                        @click="showEditModel(category, i)" v-if="isUpdatePermitted"
                                        >Edit</Button
                                    >
                                    <Button
                                        type="error"
                                        size="small"
                                        @click="showDeleteModel(
                                                category,
                                                i
                                            )
                                            /*showDeleteModel(category,i)*/
                                        " v-if="isDeletePermitted"
                                        >Delete</Button
                                    >
                                </td>
                            </tr>
                        </table>
                    </div>

                    <!--~~~~~~~ category add model ~~~~~~~~~-->

                    <Modal
                        v-model="addModel"
                        title="Add category"
                        :mask-closable="false"
                        :closable="false"
                    >
                        <Input
                            v-model="data.categoryName"
                            placeholder="Add Category name"
                        />
                        <div class="space">
                            <Upload
                                ref="upload"
                                type="drag"
                                :headers="{
                                    'x-csrf-token': token,
                                    'X-Requested-with': 'XMLHttpRequest'
                                }"
                                :on-success="handleSuccess"
                                :on-error="handleError"
                                action="category/uploadImg"
                            >
                                <div style="padding: 20px 0">
                                    <Icon
                                        type="ios-cloud-upload"
                                        size="52"
                                        style="color: #3399ff"
                                    ></Icon>
                                    <p>Click or drag files here to upload</p>
                                </div>
                            </Upload>
                            <div class="demo-upload-list" v-if="data.iconImage">
                                <img :src="`${data.iconImage}`" />
                                <div class="demo-upload-list-cover">
                                    <Icon
                                        type="ios-trash-outline"
                                        @click="deleteIcon"
                                    />
                                </div>
                            </div>
                        </div>

                        <div slot="footer">
                            <Button
                                type="default"
                                @click="
                                    addModel = false;
                                    data.categoryName = '';
                                    (data.iconImage = ''),
                                        $refs.upload.clearFiles();
                                "
                                >Close</Button
                            >
                            <Button
                                type="primary"
                                @click="addCategory"
                                :disabled="isAdding"
                                :loading="isAdding"
                                >{{
                                    isAdding ? "Adding..." : "Add category"
                                }}</Button
                            >
                        </div>
                    </Modal>

                    <!--~~~~~~~end  category add model~~~~~~-->

                    <!--~~~~~~~ category edit model ~~~~~~~~~-->

                    <Modal
                        v-model="editModel"
                        title="Edit category"
                        :mask-closable="false"
                        :closable="false"
                    >
                        <Input
                            v-model="editdata.categoryName"
                            placeholder="Add Category name"
                        />
                        <div class="space">
                            <Upload
                                v-show="isIconImageNew"
                                ref="editDataupload"
                                type="drag"
                                :headers="{
                                    'x-csrf-token': token,
                                    'X-Requested-with': 'XMLHttpRequest'
                                }"
                                :on-success="handleSuccess"
                                :on-error="handleError"
                                action="category/uploadImg"
                            >
                                <div style="padding: 20px 0">
                                    <Icon
                                        type="ios-cloud-upload"
                                        size="52"
                                        style="color: #3399ff"
                                    ></Icon>
                                    <p>Click or drag files here to upload</p>
                                </div>
                            </Upload>
                            <div
                                class="demo-upload-list"
                                v-if="editdata.iconImage"
                            >
                                <img :src="`${editdata.iconImage}`" />
                                <div class="demo-upload-list-cover">
                                    <Icon
                                        type="ios-trash-outline"
                                        @click="deleteIcon(false)"
                                    />
                                </div>
                            </div>
                        </div>
                        <div slot="footer">
                            <Button type="default" @click="closeEditModel"
                                >Close</Button
                            >
                            <Button
                                type="primary"
                                @click="editCategory"
                                :disabled="isEditting"
                                :loading="isEditting"
                                >{{
                                    isEditting ? "Editting..." : "Edit category"
                                }}</Button
                            >
                        </div>
                    </Modal>

                    <!--~~~~~~~end  category edit model~~~~~~-->

                    <!--~~~~~~~ category delete model ~~~~~~~~~-->
                    <deleteModul></deleteModul>
                    <!---<Modal v-model="deleteModel" width="360">
                            <p slot="header" style="color:#f60;text-align:center">
                                <Icon type="ios-information-circle"></Icon>
                                <span>Delete confirmation</span>
                            </p>
                            <div style="text-align:center">
                                <p>Are you sure you want to delete this category ?</p>
                            </div>
                            <div slot="footer">
                                <Button type="error" size="large" long  @click="deleteCategory()">Delete</Button>
                            </div>
                        </Modal>
                       <Modal
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
            </div>
        </div>
    </div>
</template>
<script>

import deleteModul from "../components/deleteModul.vue";
import { mapGetters } from "vuex";

export default {
    data() {
        return {
            data: {
                categoryName: "",
                iconImage: ""
            },
            editdata: {
                categoryName: "",
                iconImage: ""
            },
           // deletedata: "",
            addModel: false,
            editModel: false,
           // deleteModel: false,
            isAdding: false,
            isEditting: false,
            //isDeleting: false,
            categories: [],
            index: -1,
            token: "",
            isIconImageNew: false,
            isEdittingItem: false
        };
    },
    computed: {
        ...mapGetters(["getDeleteObj", "getDeleteInf"])
    },
    components:{
       deleteModul
    },
    methods: {
        async addCategory() {
            if (this.data.categoryName.trim() == "")
                return this.e("Category name is required");
            if (this.data.iconImage.trim() == "")
                return this.e("Icon image is required");
            this.data.iconImage = `${this.data.iconImage}`;
            const res = await this.callApi(
                "post",
                "/category/create_category",
                this.data
            );
            console.log(res);
            if (res.status === 201) {
                this.isAdding = true;
                this.categories.unshift(res.data);
                this.s("category is inserted correctly");
                this.addModel = false;
                this.data.categoryName = "";
                this.data.iconImage = "";
                this.isAdding = false;
            } else {
                if (res.status === 422) {
                    if (res.data.errors.categoryName) {
                        this.e(res.data.errors.categoryName[0]);
                    } else {
                        if (res.data.errors.iconImage) {
                            this.e(res.data.errors.iconImage[0]);
                        } else {
                            this.swr();
                        }
                    }
                }
            }
        },

        async editCategory() {
            if (this.editdata.categoryName.trim() == "")
                return this.e("Category name is required");
            if (this.editdata.iconImage.trim() == "")
                return this.e("Icon image is required");
            const res = await this.callApi(
                "post",
                "/category/edit_category",
                this.editdata
            );
            if (res.status === 200) {
                ///this.isEditting=true;
                this.categories[
                    this.index
                ].categoryName = this.editdata.categoryName;
                this.s("Category name is edited correctly");
                this.editModel = false;
                this.data.categoryName = "";
                this.isEditting = false;
            } else {
                if (res.status === 422) {
                    if (res.data.errors.categoryName) {
                        this.e(res.data.errors.categoryName[0]);
                    } else {
                        if (res.data.errors.iconImage) {
                            this.e(res.data.errors.iconImage[0]);
                        } else {
                            this.swr();
                        }
                    }
                }
            }
        },
        showEditModel(category, index) {
            /*let obj={
               id:category.id,
               categoryName:category.categoryName,
               iconImage:category.iconImage
           };*/
            this.editdata = category;
            this.editModel = true;
            this.index = index;
            this.isEdittingItem = true;
        },
        closeEditModel() {
            this.isEdittingItem = true;
            this.editModel = false;
        },

        async deleteCategory() {
            const res = await this.callApi(
                "post",
                "/category/dalate_category",
                this.deletedata
            );
            //console.log(res);
            if (res.data == 0) {
                this.w("Category name is Not Found");
            } else {
                if (res.status === 200) {
                    //this.isDeleting=false;
                    this.categories.splice(this.index, 1);
                    this.s("Category name is deleted correctly");
                    this.deleteModel = false;
                } else {
                    this.swr();
                }
            }
        },

        showDeleteModel(category, index) {
            const deleteModulObj = {
                showDeleteModul: true,
                deleteUrl: "/category/delete_category",
                data: category
            };
            this.$store.commit("setDeletingModulObj", deleteModulObj);
            this.$store.commit("setDeleteModul", true);
            this.$store.commit("setDeleteInf", {
                isDeleting: false,
                deletingIndex: index
            });

            /* this.deletedata=category;
            this.deleteModel=true;
            this.index=index;*/
        },

        async deleteIcon(isAdd = true) {
            //console.log(this.data.iconImage);
            let image = "";
            if (!isAdd) {
                //fot edit ....
                this.isIconImageNew = true;
                image = this.editdata.iconImage;
                this.editdata.iconImage = "";
                this.$refs.editDataupload.clearFiles();
            } else {
                image = this.data.iconImage;
                this.data.iconImage = "";
                this.$refs.upload.clearFiles();
            }
            //console.log(image);
            const res = await this.callApi("post", "/category/deleteImg", {
                imageName: image
            });
            if (res.status != 200) {
                this.data.iconImage = image;
                this.swr();
            }
        },

        handleSuccess(res, file) {
            res = `/uploads/${res}`;
            if (this.isEdittingItem) {
                return (this.editdata.iconImage = res);
            }
            this.data.iconImage = res;
        },
        handleError(res, file) {
            // console.log('file',file);
            // console.log('res',res);
            this.$Notice.warning({
                title: "The file format is incorrect",
                desc: `${
                    file.errors.file.length
                        ? file.errors.file[0]
                        : "Something was wrong"
                }`
            });
        },
        handleFormatError(file) {
            this.$Notice.warning({
                title: "The file format is incorrect",
                desc:
                    "File format of " +
                    file.name +
                    " is incorrect, please select jpg or png."
            });
        },
        handleMaxSize(file) {
            this.$Notice.warning({
                title: "Exceeding file size limit",
                desc: "File  " + file.name + " is too large, no more than 2M."
            });
        }

        /*async deleteCategory(){
           if(false){
              return this.e('Category name is required');
           }else{
               const res=await this.callApi('post','/category/dalate_category',this.deletedata);
               if(res.status===200 ){
                   this.isDeleting=true;
                   this.categories.splice(this.index,1);
                   this.s('Category name is deleted correctly');
                   this.deleteModel=false;
                   this.isDeleting=false;
               }else{
                   this.swr();
               }

           }
       },*/
    },
    async created() {
        this.token = window.Laravel.csrfToken;
        const res = await this.callApi("get", "/category/get_categories");
        if (res.status === 200) {
            this.categories = res.data;
        } else {
            this.swr();
        }
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
                console.log(obj.deletingIndex);
                this.categories.splice(obj.deletingIndex,1);
            }
        }
    }
};
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
