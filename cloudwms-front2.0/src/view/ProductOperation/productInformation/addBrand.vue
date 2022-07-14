<template>
  <!-- 商品分类页面 -->
  <!-- <el-container>
    <el-header>
      <sidebar></sidebar>
    </el-header>
    <el-main> -->
      <!-- 表格 -->
      <div class="table_backCol">
        <!-- 表格 -->
       <el-form ref="form" :model="form" label-width="80px" >
         <el-row>
  <el-form-item label="中文" >
    <el-col><el-input v-model="form.zh" >
    </el-input></el-col>
  </el-form-item>
  <el-form-item label="英文" >
     <el-input v-model="form.en"></el-input>
  </el-form-item>
  </el-row><el-row>
  <el-form-item label="日文">
     <el-input v-model="form.janpanese"></el-input>
  </el-form-item>
  <el-form-item label="官网">
    <el-input v-model="form.janpanese"></el-input>
  </el-form-item>
  </el-row>
  <el-form-item label="其他网店">
    <div class="addOnline">
      <el-table
      :data="addOnline"
      ref="table"
      >
      <el-table-column label="序号"  type="index" width="60" align="center"></el-table-column>
      <el-table-column  label="选择渠道" align="center">
                <template #default="scope">
                  <el-select v-model="scope.row.value" placeholder="请选择">
    <el-option
      v-for="item in channel"
      :key="item.value"
      :label="item.label"
      :value="item.value"
      >
    </el-option>
    </el-select>
    </template>
  
                
      </el-table-column>
      <el-table-column label="网店名称">
                <template #default="scope">
                  <el-input class="shopname" v-model="scope.row.shopname"></el-input>
                </template>
      </el-table-column>
      <el-table-column
            label="操作"
            prop="operate"
            size="small"
            width="200px"
            align="center"
            fixed="right"
          >
            <template v-slot="scope">
              <div class="tableBtn">
                <el-button
                  type="primary"
                  size="small"
                  @click.prevent="addRow()"
                  >添加</el-button
                >
                <el-button
                  type="danger"
                  size="small"
                  @click="delData(scope.$index, addOnline)"
                  :disabled="scope.$index === 0"
                  >删除</el-button
                >
              </div>
            </template>
          </el-table-column>
      </el-table>
    </div>
  </el-form-item>
  <el-form-item label="所属分类">
   <el-select v-model="form.value2" placeholder="请选择">
    <el-option
      v-for="item in options1"
      :key="item.value"
      :label="item.label"
      :value="item.value">
    </el-option>
  </el-select>
  </el-form-item>
  <el-form-item label="备注">
    <el-input type="textarea" v-model="form.desc"></el-input>
  </el-form-item>
  <el-form-item>
    <el-button type="primary" @click="onSubmit">立即创建</el-button>
    <el-button>取消</el-button>
  </el-form-item>
</el-form>
      </div>  
    <!-- </el-main>
  </el-container> -->
</template>
<script>
import Sidebar from "@/components/Loyout/Sidebar/Sidebar.vue";
export default {
  components: {
    Sidebar,
  },
  data() {
    return {
      channel: [{
          value: '选项1',
          label: '阿里'
        }, {
          value: '选项2',
          label: '京东'
        }, {
          value: '选项3',
          label: '拼多多'
        }, {
          value: '选项4',
          label: '亚马逊'
        }],
      addOnline:[
        {shopname:'',value:''}],
      form: {
          zh:'',
          en:'',
          janpanese:'',
          website:'',
          value2: '',
          desc: '',
          note:''
        },

      options1: [
        {
          value: "选项1",
          label: "护目镜",
        },
        {
          value: "选项2",
          label: "无分类",
        },
        {
          value: "选项3",
          label: "消费电子",
        },
        {
          value: "选项4",
          label: "|----耳机配件 ",
        },
        {
          value: "选项5",
          label: "|----耳机架",
        },
        {
          value: "选项6",
          label: "|----耳机线",
        },
        {
          value: "选项7",
          label: "|----耳机头",
        },
      ],
    }
  },
  
  created() {
    this.form.value2 = this.options1[0].value;
  },
  methods: {
    addRow () {
       	  var list = {
          rowNum:this.rowNum,
          shopname:'',
          value:''
   		 };
        this.addOnline.push(list)
        this.rowNum += 1;
      },
    delData (index, addOnline) {

      addOnline.splice(index, 1);
    },
    onSubmit() {
        console.log('submit!');
      },
    //路由传参数
      addBrand() {
        this.$router.push({
          path: "/productInformation/addBrand",
          query: {
            // ...item,
          },
        });
      },
      //商品资料
      proInfo() {
        this.$router.push({
          path: "/ProductManagement/productInformation",
          query: {
            // ...item,
          },
        });
      },
      //品牌资料
      brandInfo() {
        this.$router.push({
          path: "/productInformation/index",
          query: {
            // ...item,
          },
        });
      },
      //商品资料分类
      infoClassify() {
        this.$router.push({
          path: "/productInformation/infoClassify",
          query: {
            // ...item,
          },
        });
      },

  }
};
</script>
<style scoped lang="scss">
p {
  font-size: 12px;
  margin: 0px;
}
a {
  text-decoration: none;
  // font-size: 10px;
  color: #007185;
}

//顶部banner
// 文字链接
.el-header{
  background-color: $navBg;
  height: auto;
  box-shadow: 0 1px 3px 0 rgba(0, 0, 0, .12), 0 0 3px 0 rgba(0, 0, 0, .04);
  padding: 0px;
  color: #000;
}
.table_backCol {
  margin-top: 10px;
  background-color: #fff;
  border-radius: 2px;
  // padding: 12px;
  padding: 10px;
  .el-form{
    padding:20px;
  }
  
}
// 分页
</style>