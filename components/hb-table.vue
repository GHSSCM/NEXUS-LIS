<template>

  <div>

    <h6 class="mb-0 text-uppercase" v-if="title">
      <Translate :text='title??""' />
    </h6>
    <hr v-if="title"/>
    <div >
<!--      class="card"-->
      <div >
<!--        class="card-body"-->
        <div class="table-responsive">
          <div class="dataTables_wrapper dt-bootstrap5 dttable_wrapper">

            <div class="row">
              <div class="col-sm-12">
                <h1 v-if="errored">An error occured. please refresh the page.</h1>

                <table id="onetoasd03bc" class="table table-striped table-bordered dttable " role="grid" aria-describedby="example2_info" v-if="!errored">
                  <thead>
                  <tr role="row">
                    <th rowspan="1" colspan="1"  v-for="col in columns">
                      <Translate :text="col.label" />
                    </th>
                  </tr>
                  </thead>
                  <tbody>

                  <tr role="row" v-for="(u,i) in rows" :class="i % 2 === 0 ? 'even' : 'odd'" :key="'account-'+i">
                    <td class="" colspan="1" v-for="col in columns">
                      <span v-if="!col.attribute"> </span>
                      <span v-if="col.type==='counter'"> {{ i+1 }}</span>

                      <span v-if="col.type==='html'">
                        <span v-html="getNestedValue(u,col.attribute)"></span>
                      </span>
                      <span v-else-if="col.type==='date' || col.attribute==='created_at' || col.attribute==='updated_at'"> {{ getNestedValue(u,col.attribute)? getNestedValue(u,col.attribute).split("T")[0]:''  }}</span>
                      <span v-else-if="col.type==='age'">{{ getNestedValue(u,col.attribute)?calculateAge(getNestedValue(u,col.attribute)):"" }}</span>
                      <span v-else-if="col.type==='currency'">{{ getNestedValue(u,col.attribute)?`${getNestedValue(u,col.attribute)} ${getAppConfig('currency')}`:"" }}</span>
                      <span v-else-if="col.type==='action' && !u.noaction">
                        <span v-for="btn in col.buttons" >
                          <NuxtLink  :class="btn.class??'btn btn-primary btn-sm me-2'"  v-if='btn.route' :to="btn.route.replace(':uniqid',u.uniqid).replace(':id',u.id)">
                            <Translate :text="btn.label" />
                        </NuxtLink>
                           <button   :class="btn.class??'btn btn-primary btn-sm me-2'"  v-else-if='btn.call' @click="callQueryUrl(btn.call.replace(':uniqid',u.uniqid).replace(':id',u.id),btn.ask)">
                            <Translate :text="btn.label" />
                        </button>
                        </span>



                      </span>
                      <span v-else-if="col.type==='boolean'"><Translate :text="getNestedValue(u,col.attribute)?'Yes':'No' "/></span>
                      <span v-else-if="col.attribute"> {{getNestedValue(u,col.attribute)}}</span>
                    </td>
                  </tr>
                  </tbody>
                  <tfoot>
                  <tr>
                    <th rowspan="1" colspan="1" v-for="col in columns">
                      <Translate :text="col.label" />
                    </th>
                  </tr>
                  </tfoot>
                </table>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>

  </div>
</template>

<script>
import {generateRandomStringWithTimestamp} from "~/utils/helper.js";

export default{
  props:['title','url','params'],
  data(){
    const tbleId = generateRandomStringWithTimestamp(3);
    return{
      columns:[],
      rows:[],
      errored:false,
      tableId:"TABLE_"+tbleId,
      dataTableInstance:null
    }
  },
  methods:{
    getNestedValue(obj, path) {
      return path.split('.').reduce((acc, key) => acc?.[key], obj);
    },
    loadData(){
      getRequestLoad_(
          this.url,
          this.params??{},
          (x)=>{
            this.columns=x['columns'];
            this.rows = x['data'];
            setTimeout(() => {
              if(!this.dataTableInstance){
                this.dataTableInstance = loadDataTables()[this.tableId];
              }else{
                alert("already have instance");
                this.dataTableInstance.draw();
              }
            }, 500);
          },
          (x)=>{
            this.errored=true;
          }
      )
    },
    callQueryUrl(path,ask){
      if(ask){
        var r =  confirm("Are you sure?");
        if(!r){
          return;
        }
      }

      getRequestLoad_(
          path,
          {},
          (x)=>{
            this.loadData();
          },
          (x)=>{
          }
      )
    }
  },
  mounted() {
   this.loadData();
  }
}
</script>




