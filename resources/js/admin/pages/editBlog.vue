<template>
    <div>
       <div class="content">
			<div class="container-fluid">

				<!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
				<div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
					<p class="_title0">Edit blog </p>
					<div class="">
                        <div class="_input_field">
						    <Input type="text" v-model="data.title" placeholder="Title" />
					    </div>
                        <editor
                                class="editor"
                                ref="editor"
                                autofocus
                                holder-id="codex-editor"
                                save-button-id="save-button"
                                :init-data="initData"
                                @save="onUpdate"
								:config="config"
                         />
                        <!--<div id="editorjs" class="editor" ></div>-->
                        <div class="_input_field">
                            <Input  type="textarea" v-model="data.post_excerpt" :rows="4" placeholder="Post excerpt " />
                        </div>
                        <div class="_input_field">
                            <Select  filterable multiple placeholder="Select category" v-model="data.category_id">
                                <Option v-for="(c, i) in category" :value="c.id" :key="i">{{ c.categoryName }}</Option>
                            </Select>
                        </div>
                        <div class="_input_field">
                            <Select  filterable multiple placeholder="Select tag" v-model="data.tag_id">
                                <Option v-for="(t, i) in tag" :value="t.id" :key="i">{{ t.tagName }}</Option>
                            </Select>
                        </div>
                        <div class="_input_field">
                            <Input  type="textarea" v-model="data.metaDescription" :rows="4" placeholder="Meta description" />
                        </div>
                        <div class="_input_field">
                            <Button @click="save" :loading="isCreating" :disabled="isCreating">{{isCreating ? 'Please wait...' : 'Create blog'}}</Button>
                        </div>

					</div>
				</div>

			</div>
		</div>
    </div>
</template>



<script>
//let jd = {times:"" , blocks:"" , version:""} ;
//import EditorJS from '@editorjs/editorjs';
//import Header from '@editorjs/header';
//import List from '@editorjs/list';
//import ImageTool from '@editorjs/image';

//const Quote = require('@editorjs/quote');

/*const editor = new EditorJS({
     holder: 'editorjs',
     autofocus: true,
      /*tools: {
            quote: Quote,
            header: {
            class: Header,
            inlineToolbar: ['link'] ,
             },
             list: {
            class: List,
            inlineToolbar: true,
            },
            image: {
            class: ImageTool,
            config: {
                accept: 'image/*',
                endpoints: {
                byFile: 'http://127.0.0.1:8000/blog/uploadEditorImage', // Your backend file uploader endpoint
                byUrl: 'http://127.0.0.1:8000/fetchUrl', // Your endpoint that provides uploading by Url
                },
                field:'file',
                types: 'image/*',

            }
            },
      },
      data: {"time":1609846161110,"blocks":[{"type":"paragraph","data":{"text":".kdnsklv"}}],"version":"2.19.1"},
      //data: jd,
      //initData:jd,
      placeholder: 'Let`s write a post !!',
      onReady(){
          console.log("editor ready");
      },


});*/


export default {

   	data(){
		return {
            config: {
                image: {
                 // Like in https://github.com/editor-js/image#config-params
                    endpoints: {
                        byFile: 'http://127.0.0.1:8000/blog/uploadEditorImage',
                        byUrl: 'http://localhost:8090/image-by-url',
                    },
                    field: 'file',
                    types: 'image/*',
                    accept: 'image/*',
                },
			},
            initData: null,
            data: {
				title : '',
				post : '',
				post_excerpt : '',
				metaDescription : '',
				category_id : [],
				tag_id : [],
				jsonData: null
			},
			articleHTML: '',
			category : [],
			tag : [],
			isCreating: false,
		}
	},

   components:{

   },
   methods:{
         async save(){
            this.$refs.editor.save();
         },
         async onUpdate(outputData){
                let data=outputData
                await this.outputHtml(data.blocks)
                this.data.post = this.articleHTML
                console.log("the post is :" , this.data.post);
                this.data.jsonData = JSON.stringify(data)
                if(this.data.post.trim()=='') return this.e('Post is required')
                if(this.data.title.trim()=='') return this.e('Title is required')
                if(this.data.post_excerpt.trim()=='') return this.e('Post exerpt is required')
                if(this.data.metaDescription.trim()=='') return this.e('Meta description is required')
                if(!this.data.tag_id.length) return this.e('Tag is required')
                if(!this.data.category_id.length) return this.e('Category is required')
                this.isCreating = true
                /*let send_data={
                    data:this.data,
                    category_id:this.category_id,
                    tag_id:this.tag_id
                }*/
                const res = await this.callApi('post', `/blog/update-blog/${this.$route.params.id}`, this.data)
                if(res.status===200){
                    this.s('Blog has been created successfully!')
                    // redirect...
                    //this.$router.push('/blogs')
                }else{
                    if(res.status==422){
                        for(let i in res.data.errors){
                            this.e(res.data.errors[i][0])
                        }
                    }else{
                        this.swr()
                    }
                }
                this.isCreating = false

       },

       outputHtml(articleObj){
		   articleObj.map(obj => {
				switch (obj.type) {
				case 'paragraph':
					this.articleHTML += this.makeParagraph(obj);
					break;
				case 'image':
					this.articleHTML += this.makeImage(obj);
					break;
				case 'header':
					this.articleHTML += this.makeHeader(obj);
					break;
				case 'raw':
					this.articleHTML += `<div class="ce-block">
					<div class="ce-block__content">
					<div class="ce-code">
						<code>${obj.data.html}</code>
					</div>
					</div>
				</div>\n`;
					break;
				case 'code':
					this.articleHTML += this.makeCode(obj);
					break;
				case 'list':
					this.articleHTML += this.makeList(obj)
					break;
				case "quote":
					this.articleHTML += this.makeQuote(obj)
					break;
				case "warning":
					this.articleHTML += this.makeWarning(obj)
					break;
				case "checklist":
					this.articleHTML += this.makeChecklist(obj)
					break;
				case "embed":
					this.articleHTML += this.makeEmbed(obj)
					break;
				case 'delimeter':
					this.articleHTML += this.makeDelimeter(obj);
					break;
				default:
					return '';
				}
			});
		},

       post(){
           editor.save().then((outputData) => {
            console.log('Article data: ', outputData)
            }).catch((error) => {
            console.log('Saving failed: ', error)
            });
        }

   },

   async created(){
       //console.log(this.$route)
       const id=this.$route.params.id;
       //console.log(id);
       if(!id){
           console.log(id);
           //this.$router.push('/notFound');
           }
       const [blog,tag,cat]=await Promise.all([
           this.callApi('get',`/blog/get_single_blog/${id}`),
           this.callApi('get','/tag/get_tags'),
           this.callApi('get','/category/get_categories'),
       ]);
       if(cat.status==200){
           if(!blog.data){
               return this.$router.push('/notfound')
               }
            //this.data=blog.data
            console.log( blog.data)
            this.category=cat.data
            this.tag=tag.data

            for(let t of blog.data.tag){
                this.data.tag_id.push(t.id)
            }
            for(let c of blog.data.cate){
                this.data.category_id.push(c.id)
            }
            this.data.title = blog.data.title
            this.data.jsonData = blog.data.jsonData
            this.data.metaDescription = blog.data.metaDescription
            this.data.post_excerpt = blog.data.post_excerpt
            this.initData=JSON.parse(blog.data.jsonData)
            console.log("data:",this.data)

		}else{
			this.swr()
		}

   }

}
</script>

<style >
    .codex-editor{
    z-index: 0 !important;
    }
</style>

<style scoped>


    .editor{
        width: 80%;
        height: 300px;
        overflow-y: scroll;
        border: 1px solid #f1f1f1;
        border-radius: 4px;
        margin: auto;
    }

    .editor:hover{
        border: 1px solid #57a3f3;
    }

    ._input_field{
        width: 80%;
        padding:5px 0 ;
        margin: auto;
    }



</style>


