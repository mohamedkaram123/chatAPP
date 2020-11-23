<template>
    <div >
        <li class="list-group-item" :class="className"><slot></slot>
        <audio controls>
  <source :src='record' type="audio/mp3">
</audio>
       </li>
        <small class="badge float-right" :class='badgeClass'>{{ user }}</small>
    </div>
</template>

<script>
    export default {
     
        props:[
            'color',
          'user',
          'record'

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
