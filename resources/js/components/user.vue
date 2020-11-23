<template>
    <div>
 <a  >
             <li :style="stylss"   @click="getchat"  @mouseover="hoverss" @mouseleave="blurss"  class="list-group-item"><slot></slot></li>

 </a>

     
    </div>
</template>

<script>
    export default {
   data(){
       return{
           greating:''
       }
   },
        props:[
       'user_id',
       'username'
        ],
    
        mounted() {
          
        },
      computed: {

          stylss:function(){
              return{
                  backgroundColor:this.greating,
                  cursor:"pointer"
              }
          },
  

},
methods:{
        hoverss(){
    
    this.greating = "#c3e6cb"

          },


          blurss(){
                  this.greating = ""

          },
        getchat(){

this.$emit('update',{id:this.user_id,name:this.username})
}
}
    }
</script>
<style>
    #time{
        font-size: 9px;
        margin-top: 10px;
        color: black;
    }
</style>
