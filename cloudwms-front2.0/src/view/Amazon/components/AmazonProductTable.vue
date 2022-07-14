<template>
  <div class="Amazon-table">
      <el-table :data="tableData" border>
          <el-table-column type="selection" width="55"> </el-table-column>
          <el-table-column  width="55" label="状态">在售</el-table-column>
          <el-table-column  width="120" label="图片">
              <img style="width:100%" src="https://img.alicdn.com/imgextra/i4/2048310124/O1CN01i4T4Iw1Cmppcfoh0c_!!0-saturn_solar.jpg_468x468q75.jpg_.webp">
          </el-table-column>
          <el-table-column  width="55" >
            <template #header>
                <div class="el-table-column-title">
                  <div>SKU</div>
                  <span>状况</span>
                </div>
            </template>
            <div>123</div>
          </el-table-column>
          <el-table-column sortable width="120"  label="创建日期">06/26/2021 08:58:47</el-table-column>
          <el-table-column  width="100" label="FNSKU">X00319397</el-table-column>
          <el-table-column  width="100" >
              <template #header>
                  <div class="el-table-column-title">
                    <div>价格</div>
                    <span>+配送费</span>
                  </div>
              </template>
          </el-table-column>
          <el-table-column  width="150" label="商品名称">
              <template #header>
                  <div class="el-table-column-title">
                    <div>企业商品价格</div>
                    <span>+配送费</span>
                  </div>
              </template>
          </el-table-column>
          <el-table-column  width="100" label="入库数量">10</el-table-column>
          <el-table-column  width="100" label="可售">37</el-table-column>
          <el-table-column  width="100" label="不可售数量">3</el-table-column>
          <el-table-column  width="100" label="预留数量">FS-CSJ-103</el-table-column>
          <el-table-column  width="100" label="每件售出商品预计费用">FS-CSJ-103</el-table-column>
      </el-table>
      
  </div>
</template>

<script>
export default {
  props:{
    tableData:{
      type:[Array,Object],
      default:[]
    }
  },
  setup(props,content){
      console.log(props.tableData);
  }
}
</script>

<style scoped lang="scss">
.Amazon-table{
  cursor: pointer;
}
.el-table-column-title{
  text-align: center;
  color: #007185;
  span{
    font-size: 12px;
    color: #999;
  }
}
</style>