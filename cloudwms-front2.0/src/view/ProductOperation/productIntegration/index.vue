<template>
  <!-- 商品分类页面 -->
      <!-- 头部 -->
      <div class="productintegration_header">
          <div class="product_integration--list flex align-center">
            <div class="label">名称：</div>
            <el-input placeholder="请输入商品名称" v-model="search_form.title"></el-input>
          </div>
          <div class="product_integration--list flex align-center">
            <div class="label">品牌：</div>
            <el-select v-model="search_form.brand_id">
              <el-option
                v-for="item in brand_list"
                :key="item.id"
                :label="item.name"
                :value="item.id"
                style="display: flex"
              >
              </el-option>
            </el-select>
          </div>
          <div class="product_integration--list flex align-center">
            <div class="label">分组：</div>
            <el-select v-model="search_form.tags_id">
              <el-option
                v-for="item in Tag_list"
                :key="item.id"
                :label="item.name"
                :value="item.id"
                style="display: flex"
              >
              </el-option>
            </el-select>
          </div>
          <!-- <div class="product_integration--list flex align-center">
            <div class="label">公司：</div>
            <el-select v-model="search_form.company_id">
              <el-option
                v-for="item in options1"
                :key="item.value"
                :label="item.label"
                :value="item.value"
                style="display: flex"
              >
              </el-option>
            </el-select>
          </div> -->
          <!-- <div class="product_integration--list flex align-center">
            <div class="label">厂家：</div>
            <el-select v-model="value1">
              <el-option
                v-for="item in options1"
                :key="item.value"
                :label="item.label"
                :value="item.value"
                style="display: flex"
              >
              </el-option>
            </el-select>
          </div> -->
          
          <!-- <div class="product_integration--list flex align-center">
            <div class="label">市场：</div>
            <el-select v-model="value1">
              <el-option
                v-for="item in options1"
                :key="item.value"
                :label="item.label"
                :value="item.value"
                style="display: flex"
              >
              </el-option>
            </el-select>
          </div> -->
          <div class="product_integration--list flex align-center">
            <el-dropdown trigger="click">
              <el-button>
                更多操作<i class="el-icon-arrow-down el-icon--right"></i>
              </el-button>
              <template #dropdown>
                <el-dropdown-menu >
                  <el-dropdown-item>
                    <router-link to="#">选品计划</router-link>
                  </el-dropdown-item>
                  <el-dropdown-item>
                    <router-link to="#">样品采购</router-link>
                  </el-dropdown-item>
                  <el-dropdown-item>
                    <router-link to="#">商品关键词</router-link>
                  </el-dropdown-item>
                  <el-dropdown-item>
                    <router-link to="#">常见问题</router-link>
                  </el-dropdown-item>
                  <el-dropdown-item>
                    <router-link to="#">待处理商品</router-link>
                  </el-dropdown-item>
                  <el-dropdown-item>
                    <router-link to="#">耳机资料</router-link>
                  </el-dropdown-item>
                </el-dropdown-menu>
              </template>
            </el-dropdown>
          </div>
           <!-- 中间商品搜索栏 -->
          <div class="product_integration--list">
            <el-button type="primary" @click="Getlist">查询</el-button>
            <el-button @click="Cancal_Search_list">重置</el-button>
          </div>
      </div>
      <div class="product_integration--btn--list flex">
        <el-button type="primary" class="el-icon-plus" @click="AddProductdevelopment('新增')">新增</el-button>
        <el-dropdown trigger="click" class="product_integration_dropdown" @command="Command">
              <el-button>
                更多操作<i class="el-icon-arrow-down el-icon--right"></i>
              </el-button>
              <template #dropdown>
                <el-dropdown-menu >
                  <el-dropdown-item command="批量删除">
                   批量删除
                  </el-dropdown-item>
                </el-dropdown-menu>
              </template>
          </el-dropdown>
      </div>
      <!-- 表格 -->
      <div class="table_backCol">
        <!-- 表格 -->
        <el-table :data="table_Data" style="width: 100%" :border="true" @select="HandSelect" @select-all="handSelectAll">
          <el-table-column
            type="selection"
            width="55"
            :align="'center'"
            tooltip-effect="dark"
          >
        </el-table-column>
          <el-table-column label="编号" prop="id" :align="'center'">
            <template #default="scope">
              <div>{{scope.row.id}}</div>
            </template>
          </el-table-column>
          
          <el-table-column label="图片" prop="id" width="100px" :align="'center'">
            <template #default="scope">
              <div class="other_imagse">
                <el-image :src="scope.row.images.length>0?scope.row.images[0].src:'https://img0.baidu.com/it/u=2495658973,2184971954&fm=253&fmt=auto&app=138&f=JPEG?w=800&h=500'"></el-image>
              </div>
            </template>
          </el-table-column>
          <el-table-column label="状态" prop="status" :align="'center'">
            <template #default="scope">
              <el-tag :type="scope.row.status == 0?'danger':'success'">{{scope.row.status == 0?'进行中':'已完成'}}</el-tag>
            </template>
          </el-table-column>
          <el-table-column label="优先级" prop="order_status"  :align="'center'">
            <template #default="scope">
              <el-tag >{{scope.row.order_status == 1 ? '普通' : scope.row.order_status == 2 ? '优先':'置顶'}}</el-tag>
            </template>
          </el-table-column>
          <el-table-column label="商品" prop="name" :align="'center'" min-width="400px" >
            <template #header>
              <div>产品研发整合</div>
            </template>
            <template #default="scope" >
              <div class="product_name">
                名称：
                <el-link :underline="false">
                  {{ scope.row.title }}
                </el-link>
              </div>
              <div class="person_in_charge">
                负责人：
                <span class="charge_user--list" @click="MoresponTab" v-for="(item,index) in scope.row.user" :key="index">{{item.username}}</span>
              </div>
              <div class="person_in_charge">
                品牌：
                <span class="charge_user--list" @click="MoresponTab" v-for="(item,index) in scope.row.brand" :key="index">{{item.name}}</span>
              </div>
              <!-- <div class="market_user--list">
                市场：
                 <el-checkbox-group v-model="checkedCities" @change="handleCheckedCitiesChange">
                  <el-checkbox v-for="item in scope.row.market" :label="item" :key="item">{{item.name}}</el-checkbox>
                </el-checkbox-group>
              </div> -->
              <div class="person_in--related flex align-center flex-wrap" >
                <div>产品相关：</div>
                <div class="related flex align-center " v-for="(item,index) in scope.row.competitives" :key="index">
                  <!-- 烟草相关(Tobacco-Related Products) -->
                  <div class="related_pre">
                    竞品{{index+1}} 
                    <span>{{item.price}}</span>
                    <span>￥</span>
                    <el-link :underline="false" type="primary" :href="item.url" target="_blank">
                      Beast
                    </el-link>
                  </div>
                  <div class="related_next">
                    <el-tooltip class="item" effect="dark" content="预览数" placement="top">
                      <div>
                        <el-icon class="el-icon-view"></el-icon>
                        <span>{{item.reviews}}</span>
                      </div>
                    </el-tooltip>
                  </div>
                </div>
              </div>
                  <div class="product_images" v-if="scope.row.images.length>0">
                    <div>产品图片：
                      <el-tooltip
                        class="box-item"
                        effect="dark"
                        content="点击图片预览大图"
                        placement="top"
                      >
                        <el-icon class="el-icon-warning" style="color:#E6A23C;"></el-icon>
                      </el-tooltip>
                    </div>
                    <div class="imagse--list flex align-center flex-wrap" >
                        <div class="imagse_layui--card" v-for="(item,indexs) in scope.row.images" :key="indexs" v-show="indexs > 0 && indexs <= 9" >
                              <el-image
                                style="width: 120px; height: 120px"
                                :src="item.src"
                                fit="cover" :preview-src-list="GetPreviewSrcList(scope.row.images)"></el-image>
                          </div>
                    </div>
                    <!-- <transition-group name="el-zoom-in-top">
                      <div class="product_imagse--list" >
                        <div class="product_imagse--title flex align-center flex-wrap" @click="show = !show">
                          未分类
                          <el-link :underline="false">
                            Best Sellers
                          </el-link>
                          <el-link :underline="false">
                            How New Releases
                          </el-link>
                        </div>
                          <div class="imagse--list flex align-center flex-wrap" >
                              <transition-group name="el-zoom-in-top">
                                  <div class="imagse_layui--card" v-for="(item,indexs) in scope.row.images" :key="indexs">
                                    <img width="120" height="120" :src="item.src">
                                    <div class="imagse--list-title">LI004784 AM</div>
                                </div>
                              </transition-group>
                          </div>
                      </div>
                      </transition-group>
                      <div class="load_more" @click="LOADINGLIST()" >
                        {{loadding_title}}<i class="el-icon-loading" v-show="loadding_title == '加载中...'"></i>
                      </div> -->
                    </div>
            </template>
          </el-table-column>
          <el-table-column label="内容" prop="desc" :align="'center'" min-width="400px"  class-name="content"> 
            <template #default="scope" >
              <div class="productintegration" v-if="scope.row.transactions.length == 0 && scope.row.purchase.length == 0">
                <div class="productintegration_img">
                  <el-empty description="暂无数据"></el-empty>
                </div>
                <div class="productintegration_operating">
                    <el-link target="_blank" @click="AddExplanation(scope.row)">添加事务</el-link>
                    <el-divider direction="vertical"></el-divider>
                    <el-link type="primary" @click="AddPurchases(scope.row)">添加采购</el-link>
                    <el-divider direction="vertical" ></el-divider>
                    <el-link type="success" @click="DropdownAll('关联采购',scope.row)">关联采购</el-link>
                    <el-divider direction="vertical"></el-divider>
                    <el-link type="warning" @click="DropdownAll('关联事务',scope.row)">关联事务</el-link>
                </div>
              </div>
              <template v-else>
              <div class="explanation_title" >
                <span>内容列表</span>
                <div class="explanation_dropdown">
                  <el-dropdown size="small" trigger="click" @command="DropdownAll($event,scope.row)">
                    <span class="el-dropdown-link">
                      更多操作<i class="el-icon--right"></i>
                    </span>
                    <template #dropdown>
                      <el-dropdown-menu>
                        <el-dropdown-item command="添加事务">添加事务</el-dropdown-item>
                        <el-dropdown-item command="添加采购">添加采购</el-dropdown-item>
                        <el-dropdown-item command="关联采购">关联采购</el-dropdown-item>
                        <el-dropdown-item command="关联事务">关联事务</el-dropdown-item>
                        <!-- <el-dropdown-item command="关联计划">关联计划</el-dropdown-item> -->
                      </el-dropdown-menu>
                    </template>
                  </el-dropdown>
                </div>
              </div>
                <div class="chat_list">
                <template v-if="scope.row.transactions.length > 0">
                  <span>事务说明</span>
                  <template v-for="(item,index) in scope.row.transactions" :key="index">
                    <chat :chatlist="item" :activeindex="`${index}`" @change="ChatChange" v-if="index < 1" :responsible_person_list="responsible_person_list"></chat>
                  </template>
                  <div  class="link_list flex align-center" v-if="scope.row.transactions.length > 1 || scope.row.transactions[0].children.length >= 1">
                    <div class="title">等人</div>
                    <el-link type="primary" :underline="false" @click="AllCommit(scope.row)"> 更多回复 <el-icon class="el-icon-arrow-right"></el-icon></el-link>
                  </div>
                </template>
                <div class="purchase" v-if="scope.row.purchase.length > 0">
                  <div class="purchase_title">采购信息</div>
                  <el-table :data="scope.row.purchase" :border="true">
                    <el-table-column label="单号" prop="order_sn" min-width="120px"></el-table-column>
                    <el-table-column label="数量" prop="purchase_quantity" min-width="120px">
                      <template #default="scope">
                        <span>{{scope.row.purchase_quantity}}</span>
                      </template>
                    </el-table-column>
                    <el-table-column label="状态" prop="check" min-width="120px">
                      <template #default="scope">
                        <el-tag size="small" :type="scope.row.status == 0 ? 'info' : scope.row.status == 1? 'success': scope.row.status == 2? 'warning': 'primary'">
                          {{  scope.row.status == 0  ? "未采购" : scope.row.status == 1 ? "已采购" : scope.row.status == 2  ? "未收货" : "已收货"}}
                        </el-tag>
                      </template>
                    </el-table-column>
                    <el-table-column label="操作" min-width="120px">
                      <template #default="purchase_scope">
                        <div class="flex align-center ">
                          <el-button type="success" size="mini" @click="EditPurchase(scope.$index,purchase_scope.row,purchase_scope.$index)">编</el-button>
                          <el-button type="danger" size="mini" @click="DeletePurchase(scope.$index,purchase_scope.row,purchase_scope.$index)">删</el-button>
                        </div>
                      </template>
                    </el-table-column>
                  </el-table>
                </div>
                <!-- <div class="associate">
                  <div class="associate_title">其他关联</div>
                  <el-table :data="purchaselist" :show-header="false" :border="true">
                    <el-table-column  prop="channel" :align="'center'"></el-table-column>
                    <el-table-column  prop="unit">
                      <template #default="scope">
                        <span>{{scope.row.unit}}元</span>
                      </template>
                    </el-table-column>
                    <el-table-column  prop="check" :align="'center'" width="50px">
                      <template #default="scope">
                        <i class="check el-icon-close"></i>
                      </template>
                    </el-table-column>
                    <el-table-column  prop="status" :align="'center'">
                      <template #default="scope">
                        <el-tag type="">{{scope.row.status==0?'未收到':'已收货'}}</el-tag>
                      </template>
                    </el-table-column>
                    <el-table-column  :align="'center'" min-width="120px">
                      <template #default="scope">
                        <div class="flex align-center" >
                          <el-button type="success" size="mini">编</el-button>
                          <el-button type="danger" size="mini">删</el-button>
                          <el-button type="primary" size="mini">关</el-button>
                        </div>
                      </template>
                    </el-table-column>
                  </el-table>
                </div> -->
              </div>
              </template>
            </template>
          </el-table-column>
          <el-table-column label="操作" width="150px"  :align="'center'" fixed="right"> 
              <template #default="scope" >
                <el-link type="primary" size="small" @click="AddProductdevelopment('编辑',scope.row.id)"  >编辑</el-link>
                <el-divider direction="vertical"></el-divider>
                <el-link type="primary" size="small" @click="Delete_TableData(scope.row)"   >删除</el-link>
                <el-divider direction="vertical"></el-divider>
                <el-link type="primary" size="small" @click="Detail_TableData(scope.row)"   >详情</el-link>
              </template>
          </el-table-column>
        </el-table>
        <!-- 分页 -->
        <div class="pagination-list">
            <el-pagination
              @size-change="handleSizeChange"
              @current-change="handleCurrentChange"
              :current-page="pagination.page_num"
              :page-sizes="[3, 5, 8, 10]"
              :page-size="pagination.per_page_num"
              layout="total, sizes, prev, pager, next, jumper"
              :total="pagination.total"
            >
            </el-pagination>
          </div>
      </div>

        <!-- 责任人 -->
        <el-dialog title="修改责任人" v-model="responTab" custom-class="respon_checkbox--list" top="20px">
          <template #title>
            <div class="el-dialog_title">
              <div class="title">新增</div>
              <div class="icon_list">
                <div class="screenfull" @click="Screen" >
                      <svg  class="screen-out"   width="18" height="18" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M33 6H42V15" stroke="#000000" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/><path d="M42 33V42H33" stroke="#000000" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/><path d="M15 42H6V33" stroke="#000000" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/><path d="M6 15V6H15" stroke="#000000" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/></svg>
                </div>
                <i class="el-icon-close" @click="Close"></i>
              </div>
            </div>
          </template>
          <div class="respnTab_title">产品</div>
          <el-checkbox-group v-model="checkList">
            <el-checkbox label="复选框 A"></el-checkbox>
            <el-checkbox label="复选框 B"></el-checkbox>
            <el-checkbox label="复选框 C"></el-checkbox>
            <el-checkbox label="复选框 D"></el-checkbox>
            <el-checkbox label="复选框 E"></el-checkbox>
            <el-checkbox label="复选框 F"></el-checkbox>
            <el-checkbox label="复选框 G"></el-checkbox>
            <el-checkbox label="复选框 H"></el-checkbox>
            <el-checkbox label="复选框 I"></el-checkbox>
            <el-checkbox label="复选框 J"></el-checkbox>
            <el-checkbox label="复选框 K"></el-checkbox>
            <el-checkbox label="复选框 L"></el-checkbox>
            <el-checkbox label="复选框 M"></el-checkbox>
            <el-checkbox label="复选框 N"></el-checkbox>
          </el-checkbox-group>
          <div class="respnTab_title">市场</div>
          <el-checkbox-group v-model="checkList">
            <el-checkbox label="复选框 A"></el-checkbox>
            <el-checkbox label="复选框 B"></el-checkbox>
            <el-checkbox label="复选框 C"></el-checkbox>
            <el-checkbox label="复选框 D"></el-checkbox>
            <el-checkbox label="复选框 E"></el-checkbox>
            <el-checkbox label="复选框 F"></el-checkbox>
            <el-checkbox label="复选框 G"></el-checkbox>
            <el-checkbox label="复选框 H"></el-checkbox>
            <el-checkbox label="复选框 I"></el-checkbox>
            <el-checkbox label="复选框 J"></el-checkbox>
            <el-checkbox label="复选框 K"></el-checkbox>
            <el-checkbox label="复选框 L"></el-checkbox>
            <el-checkbox label="复选框 M"></el-checkbox>
            <el-checkbox label="复选框 N"></el-checkbox>
          </el-checkbox-group>
          <div class="respnTab_title">采购</div>
          <el-checkbox-group v-model="checkList">
            <el-checkbox label="复选框 A"></el-checkbox>
            <el-checkbox label="复选框 B"></el-checkbox>
            <el-checkbox label="复选框 C"></el-checkbox>
            <el-checkbox label="复选框 D"></el-checkbox>
            <el-checkbox label="复选框 E"></el-checkbox>
            <el-checkbox label="复选框 F"></el-checkbox>
            <el-checkbox label="复选框 G"></el-checkbox>
            <el-checkbox label="复选框 H"></el-checkbox>
            <el-checkbox label="复选框 I"></el-checkbox>
            <el-checkbox label="复选框 J"></el-checkbox>
            <el-checkbox label="复选框 K"></el-checkbox>
            <el-checkbox label="复选框 L"></el-checkbox>
            <el-checkbox label="复选框 M"></el-checkbox>
            <el-checkbox label="复选框 N"></el-checkbox>
          </el-checkbox-group>
          <template #footer>
            <span class="dialog-footer">
              <el-button @click="dialogVisible = false">取消</el-button>
              <el-button type="primary" @click="dialogVisible = false"
                >确定</el-button
              >
            </span>
          </template>
        </el-dialog>

      <!-- 弹出事物编辑表单 -->
      <el-dialog title="编辑事务" v-model="editVisi">
        <el-descriptions>
          <el-descriptions-item label="商品 :"
            >{{ editList.name }} 现有库存：{{
              editList.num
            }}</el-descriptions-item
          >
          <el-descriptions-item label="库存sku :">{{
            editList.sku
          }}</el-descriptions-item>
        </el-descriptions>
        <el-descriptions>
          <el-descriptions-item label="提醒时间 :">
            <el-date-picker
              v-model="value1"
              type="date"
              placeholder="选择日期"
              size="mini"
            >
            </el-date-picker>
          </el-descriptions-item>
        </el-descriptions>
        <el-descriptions>
          <el-descriptions-item label="备注 :" class="des">
            <el-input
              type="textarea"
              :rows="2"
              placeholder="请输入内容"
              v-model="textarea"
            >
            </el-input>
          </el-descriptions-item>
        </el-descriptions>

        <el-checkbox label="同步到常见问题" :border="true" size="mini"> </el-checkbox>

        <template #footer>
          <div class="dialog-footer">
            <el-button @click="editVisi = false">取 消</el-button>
            <el-button type="primary" @click="editVisi = false"
              >确 定</el-button
            >
          </div>
        </template>
      </el-dialog>

      <!-- 弹出事物回应表单 -->
      <el-dialog title="事务回应" v-model="responseVisi">
        <el-descriptions>
          <el-descriptions-item label="商品 :"
            >{{ editList.name }} 现有库存：{{
              editList.num
            }}</el-descriptions-item
          >
          <el-descriptions-item label="库存sku :">{{
            editList.sku
          }}</el-descriptions-item>
        </el-descriptions>
        <el-descriptions>
          <el-descriptions-item label="提醒时间 :">
            <el-date-picker
              v-model="value1"
              type="date"
              placeholder="选择日期"
              size="mini"
            >
            </el-date-picker>
          </el-descriptions-item>
        </el-descriptions>
        <el-descriptions>
          <el-descriptions-item label="回应内容 :" class="des">
            <el-input
              type="textarea"
              :rows="2"
              placeholder="请输入内容"
              v-model="textarea"
            >
            </el-input>
          </el-descriptions-item>
        </el-descriptions>
        <el-link> 附件： </el-link>

        <template #footer>
          <div class="dialog-footer">
            <el-button @click="responseVisi = false">取 消</el-button>
            <el-button type="primary" @click="responseVisi = false"
              >确 定</el-button
            >
          </div>
        </template>
      </el-dialog>

       <!-- 添加事务   -->
      <!-- <vite-dialog v-model="Explanationdialog_status" title="添加事务">
          <div class="legend_content">
              <el-form :model="form">
                <el-form-item label="标题：" label-width="15%" label-position="right" class="legend_content--textares">
                  <div class="product_integration--input">
                    <el-input v-model="form.title"   />
                  </div>
                </el-form-item>
                <el-form-item label="状态：" label-width="15%" label-position="right">
                  <el-select v-model="form.status" placeholder="请选择类型">
                          <el-option label="待处理" value="0"></el-option>
                          <el-option label="处理中" value="1"></el-option>
                          <el-option label="已处理" value="2"></el-option>
                          <el-option label="已关闭" value="3"></el-option>
                      </el-select>
                </el-form-item>
                <el-form-item prop="company_user_id" label="发送人：" label-width="15%">
                      <el-select v-model="form.company_user_id" placeholder="请选择类型">
                          <el-option label="曾" value="0"></el-option>
                      </el-select>
                  </el-form-item>
                  <el-form-item prop="to_company_user_id" label="接收人：" label-width="15%">
                      <el-select v-model="form.to_company_user_id" placeholder="请选择类型">
                          <el-option label="小" value="0"></el-option>
                      </el-select>
                  </el-form-item>
                <el-form-item label="内容：" label-width="15%" label-position="right" class="legend_content--textares">
                  <div class="product_integration--input">
                    <el-input v-model="form.content" type="textarea" :autosize="{minRows: 6, maxRows: 12 }" />
                  </div>
                </el-form-item>
                <el-form-item label="附件：" label-width="15%" label-position="right">
                  <el-upload
                      class="upload-demo"
                      action="https://jsonplaceholder.typicode.com/posts/"
                      :on-change="handleChange"
                      :file-list="fileList"
                    >
                      <el-button type="primary" size="small">上传附件</el-button>
                    </el-upload>
                </el-form-item>
              </el-form>
          </div>
          <template #footer>
            <span class="dialog-footer">
              <el-button @click="Explanationdialog_status = false">取消</el-button>
              <el-button type="primary" @click="AddAffair"
                >确定</el-button
              >
            </span>
          </template>
      </vite-dialog> -->
      <add-affair 
         v-model="Explanationdialog_status"
        ref="addaffair"
        @CloseBusinesses="CommonCloseDialog('Explanationdialog_status')"
        :responsible_person_list="responsible_person_list"
      >
      </add-affair>
      <!-- 查看更多事务 -->
      <char-panel :chatpanelVisible="chatpanelVisible" @CharDialogClose="CommonCloseDialog" :responsible_person_list="responsible_person_list" ref="charpanel"></char-panel>
      <!-- 添加采购 -->
      <!-- <el-dialog v-model="Purchases" custom-class="respon_checkbox--list" top="20px">
          <template #title>
            <div class="el-dialog_title">
              <div class="title">添加采购 - 墙上置物架</div>
              <div class="icon_list">
                <div class="screenfull" @click="Screen" >
                      <svg  class="screen-out"   width="18" height="18" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M33 6H42V15" stroke="#000000" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/><path d="M42 33V42H33" stroke="#000000" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/><path d="M15 42H6V33" stroke="#000000" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/><path d="M6 15V6H15" stroke="#000000" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/></svg>
                </div>
                <i class="el-icon-close" @click="Close"></i>
              </div>
            </div>
          </template>
          <div class="legend_content">
            <div class="legend_content--list flex align-center">
                <div class="label_title">渠道：</div>
                <div  class="legend_list flex align-center">
                  <div class="legend_select">
                    <el-select v-model="value" placeholder="请选择">
                        <el-option
                          v-for="item in options"
                          :key="item.value"
                          :label="item.label"
                          :value="item.value">
                        </el-option>
                      </el-select>
                  </div>
                  <div class="legend_input">
                    <el-input placeholder="输入"></el-input>
                  </div>
                </div>
            </div>
            <div class="legend_content--list flex align-center">
                <div class="label_title">单价：</div>
                <div  class="legend_list flex align-center">
                  <div class="legend_select">
                    <el-select v-model="value" placeholder="请选择">
                        <el-option
                          v-for="item in options"
                          :key="item.value"
                          :label="item.label"
                          :value="item.value">
                        </el-option>
                    </el-select>
                  </div>
                  
                </div>
            </div>
            <div class="legend_content--list flex align-center">
                <div class="label_title">需求采购：</div>
                <div  class="legend_list flex align-center">
                  <div class="legend_select">
                    <el-select v-model="value" placeholder="请选择">
                        <el-option
                          v-for="item in options"
                          :key="item.value"
                          :label="item.label"
                          :value="item.value">
                        </el-option>
                    </el-select>
                  </div>
                  
                </div>
            </div>
            <div class="legend_content--list flex align-center">
                <div class="label_title">待定：</div>
                <div  class="legend_list flex align-center">
                  <div class="legend_chebox">
                    <el-checkbox v-model="checked1" label="" size="large" />
                  </div>
                  <div class="legend_input" style="margin-left:7px;" v-if="checked1">
                    <el-input placeholder="输入"></el-input>
                  </div>
                </div>
            </div>
            <div class="legend_content--list flex ">
                <div class="label_title" style="padding-top:5px;">备注：</div>
                <div  class="legend_list--textarea flex">
                    <el-input v-model="form.desc" type="textarea" :autosize="{minRows: 6, maxRows: 12 }" />
                </div>
            </div>
          </div>
          <template #footer>
            <span class="dialog-footer">
              <el-button @click="Purchases = false">取消</el-button>
              <el-button type="primary" @click="Purchases = false"
                >确定</el-button
              >
            </span>
          </template>
      </el-dialog> -->
      <add-product-purchasing
        v-model="Purchases"
        @CloseDialog="CommonCloseDialog('Purchases')"
        :WarehouseList="warehouse_list"
        ref="addPurchases"
        :responsible_person_list="responsible_person_list"
      >
      </add-product-purchasing>
      <!-- 关联采购
      关联事务
      关联计划 -->
    <vite-dialog v-model="Associate"  :title="correlation_title" width="30%">
        <el-input placeholder="请输入" v-model="correlation_id"></el-input>
        <template #footer>
            <span class="dialog-footer">
              <el-button @click="Associate = false">取消</el-button>
              <el-button type="primary" @click="Correlation_Sumbit" >确定</el-button
              >
            </span>
          </template>
    </vite-dialog>
    <!-- 新增产品研发 -->
    <productdevelopment 
      :addProint_dialog="addProint_dialog"
      :Product_type_list="Product_type_list"
      :brand_list="brand_list"
      @DialogClose="DialogClose"
      :market_list="market_list"
      :supplierlist="supplierlist"
      :responsible_person_list="responsible_person_list"
      ref="productdevelopment"
      :Tag_list="Tag_list"

    ></productdevelopment>
    <!-- 修改产品研发 -->
    <edit-productdevelopment
      :addProint_dialog="editProint_dialog"
      :Tag_list="Tag_list"
      :brand_list="brand_list"
      @DialogClose="DialogClose"
      :market_list="market_list"
      :supplierlist="supplierlist"
      :responsible_person_list="responsible_person_list"
      ref="editproductdevelopment"
    ></edit-productdevelopment>

</template>
<script>
import Sidebar from "@/components/Loyout/Sidebar/Sidebar.vue";
import {GetproductDevelopmentList,DeleteProductDevelopment } from '@/api/productDevelopmentList.js'
import Productdevelopment from './components/Productdevelopment.vue'
import {GetProductCategoryList,AddingProduct,GetProductDetail} from '@/api/Addproduct'
import { onMounted, reactive, toRefs,ref } from 'vue';
import { useStore } from 'vuex';
import { shoElmessage, shoElMessageBox } from '../../../utils/Elmessage';
import EditProductdevelopment from "./components/EditProductdevelopment.vue";
import ViteDialog from '../../../components/ViteDialog/index.vue'
import { Addtransaction,Correlation_Transaction,Correlation_Purchase } from '@/api/transaction.js'
import { GetproductTagsList } from '@/api/Tags.js'
import { GetBrandlist } from "@/api/brandManagement";
import chat from './components/chat.vue'
import CharPanel from './components/CharPanel.vue';
import AddAffair from '../../affair/components/Addaffair.vue'
import { isNaLL ,getLocalTime} from '../../../utils/utils';
import {GetSupplierList } from '@/api/supplierManagement'
import { GetwarehouseList } from "@/api/warehouseList";
import AddProductPurchasing from './components/AddProductPurchasing.vue';
import { deletePurchaseList } from "@/api/purchasingMan";
import { companyUserList } from '../../../api/memberCom';
import { useRouter } from "vue-router";
export default {
  components: {
    Sidebar,
    Productdevelopment,
    EditProductdevelopment,
    ViteDialog,
    chat,
    CharPanel,
    AddAffair,
    AddProductPurchasing,
  },
  setup(props,content){
    const router = useRouter();
    const store = useStore();
    //新增弹出框dom
    const productdevelopment = ref(null);
    //修改弹出框dom
    const editproductdevelopment = ref(null)

    const addPurchases = ref(null)
    //事务
    const charpanel = ref(null);
    const addaffair = ref(null)
    const data = reactive({
        search_form:{
          title:"",
          brand_id:"",
          tags_id:"",
        },
        //弹出框
        addProint_dialog:false,
        //修改弹出框
        editProint_dialog:false,
        //分组
        Product_type_list:[],
        //品牌列表
        brand_list:[],
        //市场列表
        market_list:[],
        //供应商列表
        supplierlist:[],
        //负责人列表
        responsible_person_list:[],
        //列表
        table_Data:[],
        //修改id
        edit_id:'',
        //对应类型id
        type_id:'',
        //添加事务
        Explanationdialog_status:false,
        form:{
          title:"",
          region:"",
          content:"",
          status:'',
          company_user_id:3,
          to_company_user_id:3,
        },
        pagination:{
          page_num:1,
          per_page_num:10,
          total:10,
        },
        imagse_status:[],

        //事务列表
        chatpanelVisible:false,

        //添加采购
        Purchases:false,
        //创库
        warehouse_list:[],
        //关联弹出框
        Associate:false,
        correlation_title:'请输入关联Id',
        correlation_id:'',
        correlation_development_id:'',

        preview_src_list:[],
        //分组列表
        Tag_list:[],
        user_list:[],
        delete_table_data_list:[],
    })
    function AddProductdevelopment(item,Id){
      if(item == '新增'){
        DialogClose('新增');
        productdevelopment.value.Init();
      }else{
        DialogClose('编辑');
        editproductdevelopment.value.Init(Id);
      }
    }
      //获取商品类型
    function GetProducttypelist(){
      GetProductCategoryList({
        company_id:store.state.userinfo.userinfo.company_id,
      }).then(res =>{
          if(res.code == 1){
            data.Product_type_list = res.data
          }
      })
    }
    //关闭弹出框
    function DialogClose(item){
      if(item == '新增'){
        data.addProint_dialog = !data.addProint_dialog
      }else{
        data.editProint_dialog = !data.editProint_dialog
      }
      Getlist();
    }
    //回复评论
    function ChatChange(){
      Getlist();
    }
    //获取列表
    function Getlist() {
        GetproductDevelopmentList({
          company_id:store.state.userinfo.userinfo.company_id,
          ...data.search_form,
        }).then((result) => {
            data.table_Data = result.data.data
        })
    }
    //统一删除table
    function Deletelist(item){
      shoElMessageBox('确定删除当前这条产品研发，获取删除多条，慎重删除？').then(() =>{
        DeleteProductDevelopment({
          product_development_ids:item
        }).then(res =>{
          if(res.code == 1){
            shoElmessage(true,'删除成功')
            Getlist();
          }else{
            shoElmessage(true,'删除失败','error')
          }
        })
      })
    }
    //删除
    function Delete_TableData(item){
      Deletelist(item.id)
    }
    onMounted(() =>{
      GetTaglist()
      Getlist()
      GetProducttypelist()
    })
    //添加事务说明
    function AddExplanation(item){
      data.form = {
          title:"",
          region:"",
          content:"",
          status:'0',
          company_user_id:3,
          to_company_user_id:3,
      },
      data.Explanationdialog_status = true
      addaffair.value.Init({
        title:"新增产品研发关联事务",
        id:item.id,
        type:1,
      })
    }
    //添加事务
    function CloseBusinesses(){
      Getlist()
      data.Explanationdialog_status = false;
    }
    //分组列表
    function GetTaglist(){
      GetproductTagsList({
        company_id:store.state.userinfo.userinfo.company_id,
        per_page_num:1000000,
      }).then(res =>{
        if(res.code == 1 ){
          data.Tag_list = res.data.data
        }
      })
      //获取品牌列表
      GetBrandlist({
           company_id:store.state.userinfo.userinfo.company_id,
           per_page_num:1000000,
        }).then(res =>{
          if(res.code == 1){
            data.brand_list = res.data.data
          }
        })  
      //获取供应商
      GetSupplierList({
        company_id:store.state.userinfo.userinfo.company_id,
      }).then(res =>{
        data.supplierlist = res.data.data
      })
      GetwarehouseList({
           company_id:store.state.userinfo.userinfo.company_id,
           per_page_num:1000000,
        }).then(res =>{
          if(res.code == 1){
            data.warehouse_list = res.data.data
          }
        })
        companyUserList({
          company_id:store.state.userinfo.userinfo.company_id,
          per_page_num:1000000,
        }).then(res =>{
          if(res.code == 1){
            data.responsible_person_list = res.data.data
          }
        })
    }
    // 监听pagesize改变
    function handleSizeChange(newSize) {
      data.lis = [];
      data.pagination.pagesize = newSize;
      data.Getlist();
    }
    // 监听pagenum的改变
    function handleCurrentChange(newPage) {
      data.lis = [];
      data.pagination.pagenum = newPage;
      data.Getlist();
    }
    //加载图片
    function TOGGLE_IMAGSE_STATUS(index){
      data.imagse_status[index] = !data.imagse_status[index]
    }
    //加载图片列表
    function LOADINGLIST(){
      if(data.list.length > data.load_number){
        data.loadding_title = '加载中...'
        data.load_number += 2;
      }else{

      }
      data.loadding_title = '点击加载更多....'
    }
    function MoresponTab(){
      data.responTab = !data.responTab
    }
    //更多操作
    function DropdownAll(event,item){
      data.correlation_id = '',
      data.correlation_development_id = '',
      data.correlation_title = ''
      if(event == '添加事务'){
        AddExplanation(item)
      }else if(event == '添加采购'){
        AddPurchases(item)
      }else if(event == '关联采购'){
        data.correlation_title = `请输入关联采购信息（例ID）`
        data.correlation_development_id = item.id,
        CommonOpenDialog('Associate',item)
      }else if(event == '关联事务'){
        data.correlation_title = `请输入关联事务信息（例ID）`
        data.correlation_development_id = item.id,
        CommonOpenDialog('Associate',item)
      }
    }
    //更多内容回复
    function AllCommit(item){
      charpanel.value.Init({
        ...item,
        type:1,
      })
      data.chatpanelVisible = true;
    }
    //公共关闭弹出框
    function CommonCloseDialog(Key){
      data[Key] = false;
      Getlist()
    }
    function CommonOpenDialog(key,item = null){
      data[key] = true
    }
    //添加采购
    function AddPurchases(item){
      data.Purchases = true
      addPurchases.value.Init({
        title:'新增',
        id:item.id
      });
    }
    //关联所有操作
    function Correlation_Sumbit(){
      if(!isNaLL(data.correlation_id)){
        shoElmessage(true,'请输入关联ID','error')
      }
      if(data.correlation_title == `请输入关联事务信息（例ID）`){
        Correlation_Transaction({
          product_development_id:data.correlation_development_id,
          transaction_id:data.correlation_id
        }).then(res =>{
          if(res.code == 1){
            shoElmessage(true,'关联成功')
            CommonCloseDialog('Associate')
          }else{
            shoElmessage(true,`关联失败，原因${res.msg}`,'error')
          }
        })
      }else{
        Correlation_Purchase({
          product_development_id:data.correlation_development_id,
          purchase_id:data.correlation_id
        }).then(res =>{
          if(res.code == 1){
            shoElmessage(true,'关联成功')
            CommonCloseDialog('Associate')
          }else{
            shoElmessage(true,`关联失败，原因${res.msg}`,'error')
          }
        })
      }
    }
    //获取
    function GetPreviewSrcList(item){
      return item.map(el =>{
        return el.src
      })
    }
    //编辑采购
    function EditPurchase(event,item,purchase_scope){
      data.Purchases = true
      addPurchases.value.Init({
        title:'修改',
        id:item.id
      });
    }
    //删除采购
    function DeletePurchase(event,item,purchase_scope){
      console.log(event,item,purchase_scope)
      deletePurchaseList({
        order_ids:item.id
      }).then(res =>{
        if(res.code == 1){
          Getlist()
          shoElmessage(true,'删除成功')
        }else{
          shoElmessage(true,'删除失败','error')
        }
      })
    }
    //重置
    function Cancal_Search_list(){
        data.search_form = {
          title:"",
          brand_id:"",
          tags_id:"",
        }
    }
    function HandSelect(e){
      e.forEach(element => {
        data.delete_table_data_list.push(element.id)
      });
    }
    function handSelectAll(e){
      e.forEach(element => {
        data.delete_table_data_list.push(element.id)
      });
    }
    function Command(){
      if(data.delete_table_data_list.length > 0){
        Deletelist(data.delete_table_data_list.join())
      }else{
        shoElmessage(true,'请选择删除数据','error')
      }
    }
    //产品研发详情
    function Detail_TableData(item){
      router.push({path:'/ProductManagement/ProductIntegeadtionDetail/',query:{product_development_id:item.id}})
    }
    return{
      Detail_TableData,
      Command,
      handSelectAll,
      HandSelect,
      Cancal_Search_list,
      EditPurchase,
      DeletePurchase,
      ...toRefs(data),
      AddProductdevelopment,
      GetProducttypelist,
      DialogClose,
      Getlist,
      productdevelopment,
      editproductdevelopment,
      Deletelist,
      Delete_TableData,
      AddAffair,
      AddExplanation,
      handleSizeChange,
      handleCurrentChange,
      TOGGLE_IMAGSE_STATUS,
      MoresponTab,
      LOADINGLIST,
      ChatChange,
      DropdownAll,
      AllCommit,
      CommonCloseDialog,
      charpanel,
      addaffair,
      CloseBusinesses,
      //添加采购
      AddPurchases,
      // 关联
      Correlation_Sumbit,
      GetPreviewSrcList,
      addPurchases
    }
  },
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

.el-header {
  background-color: $navBg;
  height: auto;
  box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.12), 0 0 3px 0 rgba(0, 0, 0, 0.04);
  padding: 0px;
  color: #000;
}
.productintegration_operating{
  text-align: center;
}
.productintegration_header{
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  width: 100%;
  background-color: #fff;
  font-size: 14px;
  padding: 20px 10px;
  box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 0 3px 0 rgba(0, 0, 0, 0.02);
  .product_integration--list{
    margin: 5px;
    .label{
      width: 70px;
      text-align: right;
    }
  }
}
.product_integration--btn--list{
  margin: 15px 0px;
  :deep(.product_integration_dropdown){
    margin-left: 10px;
  }
}
.product_number--priority{
  margin-top: 10px;
  .el-radio-group{
    .el-radio{
      height: auto;
    }
  }
}
// 商品列表
.table_backCol {
  background-color: #fff;
  border-radius: 2px;
  box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.12), 0 0 3px 0 rgba(0, 0, 0, 0.03);
  padding: 20px;
  .picHov {
    width: 250px;
    height: 150px;
    position: absolute;
    z-index: 22;
    display: none;
    margin: -38px 0 0 110px;
  }
  .sc:hover .picHov {
    display: block;
  }
  .title {
    margin: 12px 0;
  }
  .aList {
    font-size: 13px;
    display: flex;
    justify-content: space-between;
    a {
      margin: 3px;
    }
    a:hover {
      color: #000;
    }
  }
  .el-table {
    .el-button {
      padding: 8px;
      margin: 3px;
    }
    .el-icon-close {
      color: red;
    }
    .el-icon-check {
      color: green;
    }
  }
}
:deep(.el-table .el-table__row .el-table__cell){
    vertical-align: top ;
}
.product_name{
  text-align: left;
}
//负责人
.person_in_charge{
  display: flex;
  align-items: center;
  padding: 2px 0px;
  flex-wrap: wrap;
  .charge_user--list{
    display: block;
    padding: 3px 8px;
    // background-color: rgba(47, 84, 235,21%);
    color: #fff;
    background-color: #2b9ef8;
    font-size: 12px;
    margin: 2px;
    line-height: normal;
    border-radius: 2px;
    cursor: pointer;
  }
  .products{
    background-color: #0ed78c;
    color: #fff;
    // background-color: rgba(245, 34, 45,21%);
  }
  .market{
    background-color: #16c7b0;
    // background-color: rgba(19, 194, 194,21%);
    color: #fff;
  }
}
.market_user--list{
  display: flex;
  align-items: center;
  padding: 2px 0px;
  flex-wrap: wrap;
  .el-checkbox-group{
    line-height: normal;
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    
    .el-checkbox{
      height: auto;
      margin-right: 10px;
      padding: 3px 0px;
      .el-checkbox__label{
        padding-left: 4px;
      }
    }
  }
}
.person_in--related{
  .related{
    padding: 5px;
    background-color: #fff;
    width: 100%;
    justify-content: space-between;
    border-bottom: 1px solid rgb(247,247,247);
    &:first-child{
      margin-top: 10px;
    }
    &:last-child{
      margin-bottom: 10px;
      border: none;
    }
    a{
      padding: 2px 4px;
      border: 1px solid #eee;
      font-size: 12px;
      line-height: normal;
      border-radius: 2px;
      margin:0px 5px;
      background-color: #f9f9f9;
    }
    .related_pre{
      span{
        font-size: 12px;
        &:first-child{
          color: red;
        }
      }
    }
    .related_next{
      cursor: pointer;
      span{
        margin-left: 5px;
        font-size: 12px;
      }
    }
  }
}
//产品图
.product_images{
  text-align: left;
  cursor: pointer;
  .load_more{
    text-align: center;
    cursor: pointer;
    color: #409EFF;
  }
  .product_imagse--list{
    margin-top: 5px;
    padding: 10px;
    max-height: auto;
    .product_imagse--title{
      font-weight: bold;
      a{
        padding: 2px 4px;
        border: 1px solid #eee;
        font-size: 12px;
        line-height: normal;
        border-radius: 2px;
        margin:0px 4px;
      }
    }
    .toggle_images{
      width: 100%;
      padding: 10px 0px;
      color: #409EFF;
      cursor: pointer;
    }
  }
  .imagse--list{
    // background-color: #f9f9f9;
    margin-top: 10px;
    .imagse_layui--card{
      width: 120px;
      border: 1px solid #ddd;
      overflow: hidden;
      // background-color: #f9f9f9;
      display: flex;
      align-items: center;
      flex-wrap: wrap;
      cursor: pointer;
      .imagse--list-title{
        text-align: center;
        line-height: 25px;
        font-size: 12px;
        height: 25px;
        width: 100%;
        background-color: #fff;
      }
    }
  }
}
// 分页
.pagination-list{
  padding: 15px 0px;
}
.explanation_title{
    display: flex;
    align-items: center;
    justify-content: space-between;
    .explanation_dropdown{
      cursor: pointer;
      .el-dropdown-link{
        color: #409EFF;
      }
    }
}
.purchase{
  margin-top: 20px;
  .purchase_title{
    padding: 10px 0px;
    text-align: left;
  }
  .check{
    font-weight: bold;
    font-size: 20px;
  }
}
.associate{
  margin-top: 20px;
  .associate_title{
    padding: 10px 0px;
  }
}
.respon_checkbox--list{
  .respnTab_title{
    padding: 10px 10px;
    background-color: #eee;
  }
  .el-checkbox-group{
    padding: 0px 20px;
    .el-checkbox{
      width: 150px;
      margin: 0px;
    }
  }
  .legend_content{
    padding: 10px;
    .legend_content--list{
      margin-bottom: 22px;
      .label_title{
        width: 70px;
        text-align: right;
      }
      .legend_list--textarea{
          flex: 1;
      }
      .legend_list{
        
        .legend_select{
          // width: 150px;
        }
        .legend_input{
          margin-left: 10px;
        }
      }
    }
  }
}
.el-dialog_title{
  width: 100%;
  display: flex;
  justify-content: space-between;
  font-size: 18px;
  cursor: pointer;
  .icon_list{
    display: flex;
    align-items: center;
    .screenfull{
      padding: 0px 10px;
      display: flex;
      align-items: center;
    }
    i{
      font-size: 20px;
      color: #000;
      font-weight: bold;
    }
  }
}

//添加事务说明
.legend_content{
  padding: 0px 10px;
  .legend_content--textares{
    .el-form-item__label{
      line-height: normal;
    }
  }
}
.product_integration--input{
  max-width: 700px
}
.link_list{
  justify-content: flex-end;
}
.chat_list{
  text-align: left;
}
</style>
<style lang="scss">
.respon_checkbox--list{
    .el-dialog__header{
      border-bottom: 1px solid #eee;
    }
    .el-dialog__body{
      padding: 10px;
    }
    .el-dialog__footer{
      border-top: 1px solid #eee;
    }
}
.popover_img--list {
  width: auto !important;
}
.popover_img--list img {
  padding: 10px;
  width: 200px;
  height: 200px;
}
</style>