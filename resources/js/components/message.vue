<template >

    <div v-if="checkvalue.content != null">
        <li class="list-group-item" :class="className"><slot></slot>
       </li>
        <small class="badge float-right" :class='badgeClass'>{{ user }}</small>
    </div>
    <div v-else-if="checkvalue.record != null">
        <li class="list-group-item" >
<audio controls :src="checkvalue.record " ></audio>

       </li>
        <small class="badge float-right" :class='badgeClass'>{{ user }}</small>
    </div>
        <div v-else>
        <li class="list-group-item"  >

<a target="_blank"  :href="checkvalue.files" download><i style="font-size:30px;color:#2d995b" class="fa fa-arrow-circle-down"></i></a> 
{{checkvalue.files.toString().substring(checkvalue.files.lastIndexOf('/')+1)}}
       </li>
        <small class="badge float-right" :class='badgeClass'>{{ user }}</small>
    </div>

</template>
<script>

    export default {
     
        props:[
            'color',
          'user',
          'checkvalue',
        ],
        computed:{
            className(){
                return 'list-group-item-'+this.color;
            },
            badgeClass(){
                return 'badge-'+this.color;
            }
        },
        mounted() {
          
        },
    
        created(){

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
