<template>
  <div>
    <div class="row container-fluid"> 
      <div class="col-3">
        <div class="card border-primary text-center" style="max-width: 14rem;">
          <div class="card-header">Detalles del dia de hoy</div>
          <div class="card-body text-primary">
            <!--<h5 class="card-title"></h5>-->
            <p class="card-text">
              <table style="font-size:13px;text-align: right;" class="table">
                <tbody>
                  <tr>
                    <th id="titulo">Efectivo:</th>
                    <div>	
                      <td>{{$separador(total_reporte_efectivo)}}</td>
                    </div>
                  </tr>
                  <tr>
                    <th id="titulo">Abonos</th>
                    <div>
                      <div>
                        <td>0</td>
                      </div> 
                    </div>
                  </tr>
                  <tr>
                    <th id="titulo">Acredito:</th>
                    <div>
                      <td>{{$separador(saldo_credito) }}</td>
                    </div> 
                  </tr>
                  <tr>
                    <th id="titulo">Facturas pagadas</th>
                    <div>
                      <td>0</td>
                    </div>
                  </tr> 
                </tbody>
              </table>
            </p>
            <p class="card-text"></p>
            <router-link class="nav-link btn btn-primary" :to="{name: 'venta'}">
            <i class="fas fa-cash-register"></i>Venta</router-link> 
          </div>
        </div>
      </div>
      <div class="col-3">
        <div class="card border-primary text-center" style="max-width: 14rem;">
          <div class="card-header">Facturas Generadas</div>
          <div class="card-body text-primary">
            <p class="card-text">
              <i class="fas fa-file-invoice fa-5x"></i>
            </p>
            
            <router-link class="nav-link btn btn-primary" :to="{name: 'factura'}">Facturas</router-link> 
          </div>
        </div>
      </div>
      <div class="col-3">
        <div class="card border-primary text-center" style="max-width: 14rem;">
          <div class="card-header">Header</div>
          <div class="card-body text-primary">
            <p class="card-text">
              <i class="fas fa-tags fa-5x"></i>
            </p>
            <router-link class="nav-link btn btn-primary" :to="{name: 'categoria'}">Categorias</router-link>
          </div>
        </div>
      </div>
      <div class="col-3">
        <div class="card border-primary text-center" style="max-width: 14rem;">
          <div class="card-header">Header</div>
          <div class="card-body text-primary">
            <p class="card-text">
              <i class="fas fa-user-tag fa-5x"></i>
            </p>
            <router-link class="nav-link btn btn-primary" :to="{name: 'proveedor'}">Proveedores</router-link>
          </div>
        </div>
      </div>
    </div><br>
        <div class="row container-fluid"> 
      <div class="col-3">
        <div class="card border-primary text-center" style="max-width: 14rem;">
          <div class="card-header">Header</div>
          <div class="card-body text-primary">
            <p class="card-text">
              <img :src="'imagenes/productos.png'" class="img-responsive" height="70" width="70">
            </p>
            <router-link class="nav-link btn btn-primary" :to="{name: 'productos'}">Productos</router-link> 
          </div>
        </div>
      </div>
      <div class="col-3">
        <div class="card border-primary text-center" style="max-width: 14rem;">
          <div class="card-header">Header</div>
          <div class="card-body text-primary">
            <p class="card-text">
              <i class="fas fa-users fa-5x"></i>
            </p>
            <router-link class="nav-link btn btn-primary" :to="{name: 'clientes'}">Clientes</router-link> 
          </div>
        </div>
      </div>
      <div class="col-3">
        <div class="card border-primary text-center" style="max-width: 14rem;">
          <div class="card-header">Header</div>
          <div class="card-body text-primary">
            <p class="card-text">
              <i class="fas fa-people-carry fa-5x"></i> 
            </p>
            <router-link class="nav-link btn btn-primary" :to="{name: 'entradafactura'}">Inventario</router-link>
          </div>
        </div>
      </div>
      <div class="col-3">
        <div class="card border-primary text-center" style="max-width: 14rem;">
          <div class="card-header">Header</div>
          <div class="card-body text-primary">
            <p class="card-text">
              <i class="fas fa-people-carry fa-5x"></i> 
            </p>
            <router-link class="nav-link btn btn-primary" :to="{name: 'entradafactura'}">Configuracion</router-link>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import EventBus from '../../event-bus';
	export default {
		data(){
			return{
      	total_reporte_efectivo:[],
      	saldo_credito:[],
			}
		},
		created(){
		},
		mounted(){
			axios.get('http://venta.test/tablero').then(response =>{
        this.total_reporte_efectivo = response.data.total_reporte_efectivo,
        this.saldo_credito = response.data.saldo_credito
				})
		},
		methods: {
		},

}
</script>