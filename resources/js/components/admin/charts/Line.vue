<template>
<div>
  <select class="form-select w-25" v-model="yearSelected" @change="getChartData()">
  <option :value="new Date().getFullYear()">Năm {{new Date().getFullYear()}}</option>
  <option :value="new Date().getFullYear()-1">Năm {{new Date().getFullYear()-1}}</option>
  <option :value="new Date().getFullYear()-2">Năm {{new Date().getFullYear()-2}}</option>
</select>
  <LineChartGenerator
  v-if="loaded"
    :chart-options="chartOptions"
    :chart-data="chartData"
    :chart-id="chartId"
    :dataset-id-key="datasetIdKey"
    :plugins="plugins"
    :css-classes="cssClasses"
    :styles="styles"
    :width="width"
    :height="height"
  />
</div>
</template>

<script>
import { Line as LineChartGenerator } from 'vue-chartjs/legacy'

import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  LineElement,
  LinearScale,
  CategoryScale,
  PointElement
} from 'chart.js'

ChartJS.register(
  Title,
  Tooltip,
  Legend,
  LineElement,
  LinearScale,
  CategoryScale,
  PointElement
)

export default {
  name: 'LineChart',
  components: {
    LineChartGenerator
  },
  props: {
    chartId: {
      type: String,
      default: 'line-chart'
    },
    datasetIdKey: {
      type: String,
      default: 'label'
    },
    width: {
      type: Number,
      default: 400
    },
    height: {
      type: Number,
      default: 500
    },
    cssClasses: {
      default: '',
      type: String
    },
    styles: {
      type: Object,
      default: () => {}
    },
    plugins: {
      type: Array,
      default: () => []
    }
  },
  data() {
    return {
        loaded: false,
      chartData: {
        labels: [
          'Tháng 1',
          'Tháng 2',
          'Tháng 3',
          'Tháng 4',
          'Tháng 5',
          'Tháng 6',
          'Tháng 7',
          'Tháng 8',
          'Tháng 9',
          'Tháng 10',
          'Tháng 11',
          'Tháng 12',
        ],
        datasets: [
          {
            label: 'Doanh Thu (VND)',
            backgroundColor: '#a1c9f1',
            data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
          }
        ]
      },
      chartOptions: {
        responsive: true,
        maintainAspectRatio: false
      },
      yearSelected: new Date().getFullYear()
    }
  },
  created() {
    this.getChartData()
  },
  methods: {
    getChartData() {
      this.loaded = false;
      axios.get('/api/orders/'+ this.yearSelected).then(response => {
        this.chartData.datasets[0].data[0] = response.data.filter(item => item.month == 1).length == 1 ? parseInt(response.data.filter(item => item.month == 1)[0].total) : 0;
        this.chartData.datasets[0].data[1] = response.data.filter(item => item.month == 2).length == 1 ? parseInt(response.data.filter(item => item.month == 2)[0].total) : 0;
        this.chartData.datasets[0].data[2] = response.data.filter(item => item.month == 3).length == 1 ? parseInt(response.data.filter(item => item.month == 3)[0].total) : 0;
        this.chartData.datasets[0].data[3] = response.data.filter(item => item.month == 4).length == 1 ? parseInt(response.data.filter(item => item.month == 4)[0].total) : 0;
        this.chartData.datasets[0].data[4] = response.data.filter(item => item.month == 5).length == 1 ? parseInt(response.data.filter(item => item.month == 5)[0].total) : 0;
        this.chartData.datasets[0].data[5] = response.data.filter(item => item.month == 6).length == 1 ? parseInt(response.data.filter(item => item.month == 6)[0].total) : 0;
        this.chartData.datasets[0].data[6] = response.data.filter(item => item.month == 7).length == 1 ? parseInt(response.data.filter(item => item.month == 7)[0].total) : 0;
        this.chartData.datasets[0].data[7] = response.data.filter(item => item.month == 8).length == 1 ? parseInt(response.data.filter(item => item.month == 8)[0].total) : 0;
        this.chartData.datasets[0].data[8] = response.data.filter(item => item.month == 1).length == 1 ? parseInt(response.data.filter(item => item.month == 9)[0].total) : 0;
        this.chartData.datasets[0].data[9] = response.data.filter(item => item.month == 10).length == 1 ? parseInt(response.data.filter(item => item.month == 10)[0].total) : 0;
        this.chartData.datasets[0].data[10] = response.data.filter(item => item.month == 11).length == 1 ? parseInt(response.data.filter(item => item.month == 11)[0].total) : 0;
        this.chartData.datasets[0].data[11] = response.data.filter(item => item.month == 12).length == 1 ? parseInt(response.data.filter(item => item.month == 12)[0].total) : 0;
        this.loaded = true;
      })
    }
  }
}
</script>
