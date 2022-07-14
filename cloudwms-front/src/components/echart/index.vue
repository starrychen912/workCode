<template>
  <div ref="charts" :style="{width: `${style.width}%`, height: `${height}%`}" ></div>
</template>
<script lang="ts">
import { defineComponent, onMounted, ref, watch } from "vue";
import * as echarts from "echarts/core";
import {
  BarChart,
  // 系列类型的定义后缀都为 SeriesOption
  RadarChart,
  LineChart,
  PieChart,
  GaugeChart,
  ScatterChart,
} from "echarts/charts";
import {
  TitleComponent,
  LegendComponent,
  // 组件类型的定义后缀都为 ComponentOption
  TooltipComponent,
  GridComponent,
  VisualMapComponent,
  DataZoomComponent,
  MarkLineComponent,
  ToolboxComponent
} from "echarts/components";
import { CanvasRenderer } from "echarts/renderers";
// 注册必须的组件
echarts.use([
  TitleComponent,
  TooltipComponent,
  LegendComponent,
  GridComponent,
  BarChart,
  CanvasRenderer,
  LineChart,
  PieChart,
  GaugeChart,
  RadarChart,
  ScatterChart,
  VisualMapComponent,
  DataZoomComponent,
  MarkLineComponent,
  ToolboxComponent
]);
export default defineComponent({
  props: {
    option: {
      type: Object,
      default() {
        return {
              tooltip: {
                trigger: 'axis'
              },
              grid: {
                left: '9%',
                right: '9%',
                bottom: '9%',
                containLabel: false
              },
              //是否可以下载
              // toolbox: {
              //   feature: {
              //     saveAsImage: {}
              //   }
              // },
              xAxis: {
                type: 'category',
                boundaryGap: false,
                show:false,
                data: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                // splitLine: {     //网格线
                //   show: false
                // }
              },
              yAxis: {
                show:false,
                type: 'value',
                // splitLine: {
                //     show: false
                //   }
              },
              series: [
                {
                  name: 'Email',
                  type: 'line',
                  stack: 'Total',
                  data: [120, 132, 101, 134, 90, 230, 210]
                }
              ]
            };
      },
    },
    style: {
      type: Object,
      default() {
        return { width: 100, height: 300 };
      },
    },
    height:{
      type:Number,
      default:450
    }
  },
  name:"v-echart",
  setup(props: any) {
    const charts: any = ref(null);
    let myChart: any;
    onMounted(() => {
      myChart = echarts.init(charts.value);
      myChart.setOption(props.option);
      myChart.resize();
      window.addEventListener("resize", function () {
        myChart.resize();
      });
    });
    watch(
      () => props.style,
      () => {
        myChart.resize();
      }
    );
    const init = () => {
      
      try{
        // { notMerge: true } 数据清除替换
        myChart.setOption(props.option,true);
      }catch{}
    };
    return {
      charts,
      init,
    };
  },
});
</script>
