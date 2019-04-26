<template>
  <div>
    <div class="html_text--details" v-if="user.role_id != 4">
      <div class="form-line" v-if="cCAsset.btn_s == true && details.sms_verified == 0">
        <div class="cnf__input ">
          <label>SMS content ({{sms_count}} sms/ {{totalcharacter}} characters)</label>
          <textarea type="text" class="form-control cnt__textarea-lg" v-model="details.sms_script" @keyup='charCount()' :disabled="disabled"></textarea>
          <span class="error__span" v-if="errors.sms_script">{{ errors.sms_script[0] }}</span>
        </div>
      </div>
      <div class="form-line" v-if="cCAsset.btn_s == false || details.sms_verified == 1">
        <div class="cnf__input cursorDedault">
          <label>SMS content</label>
          <span class="form-control cnt__textarea-lg">{{ details.sms_script }}</span>
        </div>
      </div>
    </div>
    <div class="html_text--details"  v-if="user.role_id == 4">
      <div class="form-line" v-if="cCAsset.btn_c == false || details.sms_veridied == false">
        <div class="cnf__input ">
          <label>SMS content (1 sms/160 characters)</label>
          <textarea type="text" class="form-control cnt__textarea-lg" v-model="details.sms_script" :disabled="disabled"></textarea>
          <span class="error__span" v-if="errors.sms_script">{{ errors.sms_script[0] }}</span>
        </div>
      </div>
      <div class="form-line" v-if="cCAsset.btn_c">
        <div class="cnf__input cursorDedault">
          <label>SMS content</label>
          <span class="form-control cnt__textarea-lg">{{ details.sms_script }}</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import {Http} from '@/helpers/http-helper'

  export default{
    props:['details','errors','disabled','step','cCAsset'],
    data () {
      return {
        user: {},
        totalcharacter: 0,
        sms_count : 1
      }
    },
    computed: {
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
        this.totalcharacter = this.details.sms_script.length;
        this.sms_count = Math.ceil(this.details.sms_script.length/160)
      }
    }
  }
</script>
