require('./bootstrap');

window.Vue = require('vue');
Vue.config.productionTip = false

//Convierte a notacion de punto de mil.
Vue.prototype.$separador = function (numero) 
{
    return new Intl.NumberFormat(["ban", "id"]).format(numero);
}

//Al escribir pone el punto de mil en los numeros.
Vue.prototype.$poneralescribir = function (event) {
    
    //Se captura el evento y se usa el atributo value
    //interno en la propiedad target.
    var str = event.target.value.toString();
    //Se verifica que no este vacio el input.
    if (str == '') { 
        return $('#'+event.target.id).val('');
    }
    //Al escribir se debe tratar el string como numero
    //por lo cual se mantiene eliminando el punto de mil
    str = str.replace(/\./g,"");
    //Pasar el str a numero.
    str = parseInt(str);
    ////Convierte a notacion de punto de mil.
    str = new Intl.NumberFormat(["ban", "id"]).format(str);
    //Se pasa a str nuevamente
    //str = str.toString();
    //se pone el valor en el input detectado.
    $('#'+event.target.id).val(str);             
}

Vue.use(require('vue-resource'));


import moment from 'moment';
import { Form, HasError, AlertError } from 'vform';

window.Form = Form;
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)
Vue.component('appcomponen-component', require('./components/layouts/AppComponent.vue').default);
Vue.component('panel-component', require('./components/tablero/tablero.vue').default);
/**/ 
Vue.component('sidebar-component', require('./components/layouts/SidebarComponent.vue').default);
Vue.component('tablaproducto-component', require('./components/inventario/inventario.vue').default);
Vue.component('formulario-component', require('./components/inventario/modalinventario.vue').default);
/*proceso de los productos*/
Vue.component('tablaproductos-component', require('./components/producto/tablaproductos.vue').default);
Vue.component('modalproducto-component', require('./components/producto/modalproductos.vue').default);
/*proceso de los proveedor*/
Vue.component('tablaproveedor-component', require('./components/proveedor/tablaproveedor.vue').default);
Vue.component('agregarproveedor-component', require('./components/proveedor/modalagregarpro.vue').default);
Vue.component('eliminarproveedor-component', require('./components/proveedor/modaleliminar.vue').default);
/*proceso de los cliente*/
Vue.component('tablacliente-component', require('./components/clientes/tablaclientes.vue').default);
Vue.component('agregarcliente-component', require('./components/clientes/modalclientes.vue').default);
Vue.component('eliminarcliente-component', require('./components/clientes/modalclienteseliminar.vue').default);
/*proceso de los categorias*/
Vue.component('tablacatego-component', require('./components/categoria/tablacategoria.vue').default);
Vue.component('modalsave-component', require('./components/categoria/modalcategoriasave.vue').default);
Vue.component('modaldelete-component', require('./components/categoria/modaleliminarcate.vue').default);
/*proceso de las ventas*/
Vue.component('tablaventa-component', require('./components/venta/venta.vue').default);
Vue.component('modalventa-component', require('./components/venta/modalventa.vue').default);
/*proceso de las facturas-cliente*/
Vue.component('tablafactura-component', require('./components/factura/factura.vue').default);
Vue.component('modalfactura-component', require('./components/factura/modalfactura.vue').default);

Vue.component('camara-component', require('./components/categoria/modaleliminarcate.vue').default);
Vue.component('pagination', require('laravel-vue-pagination'));
/** 
 *Funcionalidades axios para los productos.
*/

import router from './routes'
const app = new Vue({
    el: '#app',
    router
});