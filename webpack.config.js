const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
module.exports = {
  mode: 'development',
  watch: true,
  entry: {
    'js/app' : './src/js/app.js',
    'js/inicio' : './src/js/inicio.js',
    'js/secciones/index' : './src/js/secciones/index.js',
    'js/grados/index' : './src/js/grados/index.js',
    'js/alumnos/index' : './src/js/alumnos/index.js',
    'js/tutores/index' : './src/js/tutores/index.js',
    'js/profesores/index' : './src/js/profesores/index.js',
    'js/pagos/index' : './src/js/pagos/index.js',
    'js/conductas/index' : './src/js/conductas/index.js',
    'js/pdfconductas/index' : './src/js/pdfconductas/index.js',
    'js/asistencia/index' : './src/js/asistencia/index.js',
    'js/asignaciones/index' : './src/js/asignaciones/index.js',
    'js/actividades/index' : './src/js/actividades/index.js',  
    'js/usuarios/index' : './src/js/usuarios/index.js',    
    'js/login/index' : './src/js/login/index.js',



  },
  output: {
    filename: '[name].js',
    path: path.resolve(__dirname, 'public/build')
  },
  plugins: [
    new MiniCssExtractPlugin({
        filename: 'styles.css'
    })
  ],
  module: {
    rules: [
      {
        test: /\.(c|sc|sa)ss$/,
        use: [
            {
                loader: MiniCssExtractPlugin.loader
            },
            'css-loader',
            'sass-loader'
        ]
      },
      {
        test: /\.(png|svg|jpg|gif)$/,
        loader: 'file-loader',
        options: {
           name: 'img/[name].[hash:7].[ext]'
        }
      },
    ]
  }
};