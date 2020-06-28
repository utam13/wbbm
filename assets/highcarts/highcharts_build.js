Highcharts.chart('dashboard_chart', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Nama Kegiatan'
    },
    subtitle: {
        text: '(Start Date - End Date)'
    },
    xAxis: {
        categories: [
            'Komponen 1',
            'Komponen 2',
            'Komponen 3',
            'Komponen 4',
            'Komponen 5',
            'Komponen 6',
            'Komponen 7',
            'Komponen 8',
            'Komponen 9',
            'Komponen 10',
            'Komponen 11',
            'Komponen 12'
        ],
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Nilai'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        },
		series: {
            colorByPoint: true
        }
    },
    series: [{
        //name: 'Tokyo',
		name: 'Komponen',
        data: [49.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4]

    /*}, {
        name: 'New York',
        data: [83.6, 78.8, 98.5, 93.4, 106.0, 84.5, 105.0, 104.3, 91.2, 83.5, 106.6, 92.3]

    }, {
        name: 'London',
        data: [48.9, 38.8, 39.3, 41.4, 47.0, 48.3, 59.0, 59.6, 52.4, 65.2, 59.3, 51.2]

    }, {
        name: 'Berlin',
        data: [42.4, 33.2, 34.5, 39.7, 52.6, 75.5, 57.4, 60.4, 47.6, 39.1, 46.8, 51.1] */

    }]
});