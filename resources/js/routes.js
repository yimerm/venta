import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)

export default new Router({
	routes: [
		/*{
			path:'/',
			name:'home',
			component: require('./components/layouts/AppComponent').default
		},*/
		{
			path:'/tablero',
			name:'tablero',
			component: require('./views/tablero/tablero').default
		},
		{
			path:'/categoria',
			name:'categoria',
			component: require('./views/categoria/categoria').default
		},
		{
			path:'/venta',
			name:'venta',
			component: require('./views/venta/venta').default
		},
		{
			path:'/factura',
			name:'factura',
			component: require('./views/factura/factura').default 
		},
		{
			path:'/proveedor',
			name:'proveedor',
			component: require('./views/proveedor/proveedor').default
		},
		{
			path:'/productos',
			name:'productos',
			component: require('./views/productos/productos').default
		},
		{
			path:'/clientes',
			name:'clientes',
			component: require('./views/clientes/cliente').default
		},
		{
			path:'/entradafactura',
			name:'entradafactura',
			component: require('./views/inventario/inventario').default
		},
	],
	mode: 'history'
})