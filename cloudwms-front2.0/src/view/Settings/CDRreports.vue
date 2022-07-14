<template>
    
    <div class="grid-content bg-purple-light">
      <el-card>
        <div class=" flex align-center justify-between">
                <div style="font-weight:bold;padding-bottom:20px;">GDPR reports</div>
            </div>
        <div style="padding-bottom:20px;">
        You can download GDPR data request reports by pressing on report title. Reports are deleted automatically after 30 days.Read more about GDPR data requests in
            <el-link type="info">Shopify Help Center</el-link>
        </div>
            <div style="padding:15px;background-color:rgb(232,250,255);border-radius:5px;">
                <div style="width: 30px;height:30px;color:rgb(69,156,174);font-size:20px;background-color:rgb(207,236,243);border-radius:50%;" class="flex align-center justify-center">
                    <i class="el-icon-info" ></i>
                </div>
            </div>
        </el-card>
    </div>
</template>

<script>
export default {

}
</script>

<style lang="scss" scoped>

 :deep(.el-menu  .is-active){
    border-right: none !important;
}
:deep(.el-menu-item .el i){
    display:none;
}
:deep(.is-active .el i){
    display:block;
}
:deep(.el-menu .is-active){
    background-color:#fff;
    color:#0000ff;
}
:deep(.el-menu-item span){
    text-align:center;
    font-weight:1000;
    font-size:15px;
}

</style>