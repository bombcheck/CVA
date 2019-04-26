<template>
  <div>
    <div class="html_text--details" v-if="user.role_id != 4">
      <div class="form-line" v-if="cCAsset.btn_s == true && details.call_verified == 0" >
        <div class="cnf__input ">
          <label>Call content ({{totalcharacter}}/character)</label>
          <ckeditor :editor="editor" v-model="details.call_script"  type="classic" @keyup='charCount()' :disabled="dis"></ckeditor>
          <span class="error__span" v-if="errors.call_script">{{ errors.call_script[0] }}</span>
        </div>
      </div>
      <div class="cnf__input-html" v-if="cCAsset.btn_s == false || details.call_verified == 1">
        <label>Call content</label>
        <div class="view-html" v-html="details.call_script"></div>
      </div>
    </div>
    <div class="html_text--details" v-if="user.role_id == 4">
      <div class="cnf__input-html" >
        <label>Call content</label>
        <div class="view-html" v-html="details.call_script"></div>
      </div>
    </div>
  </div>
</template>

<script>
  import {Http} from '@/helpers/http-helper'
  import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
  import Editor from 'v-markdown-editor'

  export default{
    props:['details','errors', 'cCAsset', 'step'],
    components: {
      Editor
    },
    data () {
      return {
        editor: ClassicEditor,
        editorDisabled: true,
        user: {},
        totalcharacter: 0,
        dis: false
      }
    },
    computed: function () {
    },
    watch: {
    },
    mounted: function () {
      this.getUser()
      this.charCount()
    },
    methods: {
      getUser: function () {
        Http.get(`auth/details`)
          .then(response => {
            this.user = response.data
          })
      },
      charCount: function(){
        this.totalcharacter = this.details.call_script.length;

        if(this.totalcharacter == 1600) {

        }
      }
    }
  }
</script>


