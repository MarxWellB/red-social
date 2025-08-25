@extends('layouts.app')
@section('titulo')
 - Tags
@endsection
@section('contenido')
<style>
    table {
      width: 100%;
      border-collapse: collapse;
    }

    table, th, td {
      border: 1px solid #ddd;
    }

    th, td {
      padding: 10px;
      text-align: left;
    }

    th {
      background-color: #f2f2f2;
    }

    tr:hover {
      background-color: #f5f5f5;
    }

    .buy-button {
      background-color: #4CAF50;
      color: white;
      padding: 8px 16px;
      text-align: center;
      text-decoration: none;
      display: inline-block;
      border-radius: 5px;
      cursor: pointer;
    }

    .buy-button:hover {
      background-color: #45a049;
    }
    h5,h6,p,h2{
      color:#ddd;
    }
    .card-tam{
      width: 18rem;
    }
   
.faq h3 {
    color: aliceblue;
    margin-bottom: 5px;
}
.faq-container {
    max-width: 100%;
    margin: 0 auto;
    padding: 20px;
}

.faq {
    background-color: rgb(31, 30, 30);
    padding: 15px;
    margin-bottom: 10px;
    border-radius: 5px;
}

  @media screen and (max-width: 500px) {
    .card-tam {
      width: 25rem;
    }
  }
    .card-buy{
      
      background-color:rgb(31, 30, 30);
      border-color:#555454;
    }
  </style>
<style>
  .form-container {
      background-color: rgb(31, 30, 30); 
      border-radius: 8px; 
      padding: 20px; 
      box-shadow: 0 4px 8px rgba(0,0,0,0.1); 
      max-width: 500px; 
      margin: auto;
  }

  .form-container h3 {
      color: #ddd; 
      margin-bottom: 15px; 
  }

  .form-container input[type="text"],
  .form-container input[type="email"],
  .form-container textarea {
      width: 100%; 
      padding: 10px; 
      margin-bottom: 10px; 
      border: 1px solid #ddd; 
      border-radius: 4px; 
  }
  input[type="text"],
    select {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        box-sizing: border-box;
    }

  .form-container textarea {
      height: 100px; 
      resize: vertical; 
  }

  .form-container button {
      color: #ddd; 
      border: none;
      padding: 10px 20px; 
      border-radius: 4px; 
      cursor: pointer; 
      margin-right: 10px; 
  }

  .form-container .tag {
      background-color: #6c757d; 
  }

  .form-container .tag:hover {
      background-color: #5a6268; 
  }
</style>

  
  <div class="container" style="margin-bottom: 1rem;">
  <h2 style="text-align: center;" data-section="Prom" data-value="Prom">Promotions</h2>
    <div class="center" style="display:flex;justify-content:center;flex-wrap:wrap;gap:1rem;"> 
      <div class="card card-buy card-tam" >
        <div class="card-body ">
          <h5 class="card-title" style="text-align: center;" data-section="Prom" data-value="Basic">Paquete Básico</h5>
          <hr>
          <h6 class="card-subtitle mb-2 text-body-secondary" data-section="Prom" data-value="Bprice">$29 USD en Bitcoin (BTC)</h6>
          <p class="card-text" data-section="Prom" data-value="Btime">1 día de promoción en la página</p>
          @if ($basic<=$lbasic)
              <button class="tag buy-btn miBoton basic"  style="width: 100%;" value="1" data-value="basico" ><div data-section="Prom" data-value="Buy">Buy</div></button>
          @else
            <h6 class="card-title" style="text-align: center; color:rgb(126, 46, 46);" data-section="Prom" data-value="without">Paquete Básico</h6>
          @endif
          
        </div>
      </div>
      <div class="card card-buy card-tam" >
        <div class="card-body">
          <h5 class="card-title" style="text-align: center;" data-section="Prom" data-value="Standar">Paquete Estándar</h5>
          <hr>
          <h6 class="card-subtitle mb-2 text-body-secondary"data-section="Prom" data-value="Sprice">$49 USD en Bitcoin (BTC)</h6>
          <p class="card-text" data-section="Prom" data-value="Stime">3 días de promoción en la página</p>
          @if ($medium<=$lmedium)
            <button class="tag buy-btn miBoton mid"  style="width: 100%;" value="2" data-value="estandar" ><div data-section="Prom" data-value="Buy">Buy</div></button>
          @else
          <h6 class="card-title" style="text-align: center;color:rgb(126, 46, 46);" data-section="Prom" data-value="without">Paquete Básico</h6>
          @endif
        </div>
      </div>
      <div class="card card-buy card-tam">
        <div class="card-body">
          <h5 class="card-title" style="text-align: center;" data-section="Prom" data-value="Premium">Paquete Premium</h5>
          <hr>
          <h6 class="card-subtitle mb-2 text-body-secondary" data-section="Prom" data-value="Pprice">$89 USD en Bitcoin (BTC)</h6>
          <p class="card-text">10 días de promoción en la página</p>
          @if ($premium<=$lpremium)
          <button class="tag buy-btn miBoton premium"  style="width: 100%;" value="3" data-value="premium" ><div data-section="Prom" data-value="Buy">Buy</div></button>
          @else
          <h6 class="card-title" style="text-align: center;color:rgb(126, 46, 46);" data-section="Prom" data-value="without">Paquete Básico</h6>
          @endif
        </div>
      </div>
      <div class="card card-buy card-tam">
        <div class="card-body">
            <h5 class="card-title" style="text-align: center;" data-section="Prom" data-value="Plan">Solicitar Plan</h5>
            <hr>
            <h6 class="card-subtitle mb-2 text-body-secondary" data-section="Prom" data-value="Ptext">Contacta con nosotros si quieres un plan que se ajuste a tus necesidades</h6>
            <button class="tag contact-btn" style="width: 100%;" data-section="Prom" data-value="Contac">Contactar</button>
        </div>
    </div>
</div>
<br>
<div id="purchase-form" class="form-container" style="display:none; text-align: center; margin-top: 2rem;margin-bottom:1rem;">
    <h3 data-section="Prom" data-value="Sprom">Solicitar Promoción</h3>
   

    <form action="{{ route('info.promcreate') }}" method="POST">
        @csrf
        <input  type="text" name="nombre" data-place="Form" data-val="name" placeholder="Your name" required style="outline:none; background-color: #1b1b1b; color: #fff; border: none; ">
        
        <input class="input @error('username') otro @enderror" data-place="Form" data-val="Username" type="text" name="username" placeholder="Nombre del usuario" required style="outline:none; background-color: #1b1b1b; color: #fff; border: none; ">
        @error('username')
                            <p class="error">{{$message}}</p>
                        @enderror
        <input type="email" name="email" data-place="Form" data-val="Email"  placeholder="Your Email" required style="outline:none; background-color: #1b1b1b; color: #fff; border: none; ">
        <input type="text" name="idDiscount" data-place="Form" data-val="Discount" placeholder="Código de Descuento (opcional)" style="outline:none; background-color: #1b1b1b; color: #fff; border: none; ">

      


        <div style="display: flex;column-gap:1rem;">
          
          <p style="margin-top: 1rem;margin-left:0.8rem;" data-section="Prom" data-value="Date">Fecha de inicio: </p> 
        <style>
          .date-input {
              outline: none;
              background-color: #1b1b1b;
              color: #fff;
              border: 1px solid #333; 
              padding: 10px;
              border-radius: 4px;
              width: 100%; 
          }
          
          .date-input::-webkit-calendar-picker-indicator {
              filter: invert(1);
          }
          
          </style>

        <input type="date" id="startday" min="@php echo $fecha; @endphp" name="startday" class="date" placeholder="Fecha de inicio"  style="outline:none; background-color: #1b1b1b; color: #fff; border: none; " required>
</div>
<select class="miSelect" name="paquete" id="package-select" style="outline:none; background-color: #1b1b1b; color: #fff; border: none;" >
  @if ($basic<=$lbasic)
    <option value="basico" data-section="Prom" data-value="PBasic">Paquete Básico - $29</option>
  @endif
  @if ($medium<=$lmedium)
    <option value="estandar" data-section="Prom" data-value="PStandar">Paquete Estándar - $49</option>
  @endif
  @if ($premium<=$lpremium)
    <option value="premium" data-section="Prom" data-value="PPremium">Paquete Premium - $89</option>
  @endif
</select>



        <a href="" class="tag" id="paqueteEnlace" style="text-decoration: none;" data-section="Prom" data-value="ToBuy" target="_blank">
            Proceder a Comprar
        </a>
        <input type="text" name="nowpay" data-place="Form" data-val="Id" placeholder="Id de transacción de Nowpayments" required style="outline:none; background-color: #1b1b1b; color: #fff; border: none; ">
        <script>
           document.addEventListener('DOMContentLoaded', function() {
              var selectElement = document.querySelector('.premium');
              var enlace = document.getElementById('paqueteEnlace');
          
              selectElement.addEventListener('click', function() {
                  var seleccion = this.value;                  
                  enlace.href = 'https://nowpayments.io/payment/?iid=5944036524';                      
                  });
              });

           document.addEventListener('DOMContentLoaded', function() {
              var selectElement = document.querySelector('.mid');
              var enlace = document.getElementById('paqueteEnlace');
          
              selectElement.addEventListener('click', function() {
                  var seleccion = this.value;
                  
                          enlace.href = 'https://nowpayments.io/payment/?iid=4502118723';
                                          
              });
          });

          document.addEventListener('DOMContentLoaded', function() {
              var selectElement = document.querySelector('.basic');
              var enlace = document.getElementById('paqueteEnlace');
          
              selectElement.addEventListener('click', function() {
                  var seleccion = this.value;
                  
                          enlace.href = 'https://nowpayments.io/payment/?iid=5020498476';
                                      
              });
          });


          document.addEventListener('DOMContentLoaded', function() {
              var selectElement = document.getElementById('package-select');
              var enlace = document.getElementById('paqueteEnlace');
          
              selectElement.addEventListener('click', function() {
                  var seleccion = this.value;
                  
                  switch(seleccion) {
                      case 'basico':
                          enlace.href = 'https://nowpayments.io/payment/?iid=5020498476';
                          break;
                      case 'estandar':
                          enlace.href = 'https://nowpayments.io/payment/?iid=4502118723';
                          break;
                      case 'premium':
                          enlace.href = 'https://nowpayments.io/payment/?iid=5944036524';
                          break;
                      default:
                          enlace.href = '';
                          enlace.textContent = 'Selecciona un paquete';
                  }
              });
          });
          </script>
          
        <div  style="display: flex;margin-top:1rem;">
          <button style="width: 50%;" type="submit" class="tag" data-section="Prom" data-value="Send">Enviar Solicitud</button>
          <button style="width: 50%;" type="button" class="tag" onclick="document.getElementById('purchase-form').style.display='none'" data-section="Prom" data-value="Cancel">Cancelar</button>
        </div>
    </form>
</div>

<div id="contact-form" class="form-container" style="display:none; text-align: center; margin-top: 2rem;margin-bottom:1rem;">
    <h3 data-section="Prom" data-value="Personalizate">Contactar para Plan Personalizado</h3>
    <form action="{{ route('info.promcreateu') }}" method="POST">
        @csrf
        <input type="text" name="nombre" data-place="Form" data-val="name" placeholder="Your name" required style="outline:none; background-color: #1b1b1b; color: #fff; border: none; ">
        <input type="email" name="email" data-place="Form" data-val="Email" placeholder="Your Email Address" required style="outline:none; background-color: #1b1b1b; color: #fff; border: none; "> 
        <textarea name="mensaje" minlength="10" data-place="Form" data-val="Describe" placeholder="Describe your needs" style="outline:none; background-color: #1b1b1b; color: #fff; border: none; " required></textarea>
        <div style="display: flex;margin-top:1rem;">
          <button style="width: 50%;" type="submit" class="tag" data-section="Prom" data-value="Send">Enviar Solicitud</button>
          <button style="width: 50%;" type="button" class="tag"  onclick="document.getElementById('contact-form').style.display='none'" data-section="Prom" data-value="Cancel">Cancelar</button>
        </div>
    </form>
</div>


<script>
 document.addEventListener('DOMContentLoaded', (event) => {
    function hideAllForms() {
        document.querySelectorAll('.form-container').forEach(form => {
            form.style.display = 'none';
        });
    }

    document.querySelectorAll('.buy-btn').forEach(button => {
        button.addEventListener('click', function() {
            hideAllForms();
            document.querySelector('.miSelect').value = this.getAttribute('data-value');
            document.getElementById('purchase-form').style.display = 'block';
        });
    });

    document.querySelectorAll('.contact-btn').forEach(button => {
        button.addEventListener('click', function() {
            hideAllForms();
            document.getElementById('contact-form').style.display = 'block';
        });
    });
});

  </script>
  <div class="faq-container" data-section="Prom" data-value="QA">

    <div class="faq">
      <h3>¿Puedo promocionar una cuenta que no sea mía?</h3>
      <p>Sí, al comprar un paquete puedes indicar tu nombre de usuario o el de la persona que deseas promocionar, sin el símbolo "@". Se notificará sobre la promoción luego de procesada al correo electrónico proporcionado y a la cuenta de la plataforma oficial de la persona promocionada.</p>
  </div>
  
    <div class="faq">
        <h3>¿Cómo puedo comprar una promoción?</h3>
        <p>Elige el paquete de promoción que prefieras y haz clic en "Comprar". Completa el formulario y sigue las instrucciones para realizar tu pago en Bitcoin a través de una plataforma como Binance.</p>
    </div>

    <div class="faq">
        <h3>¿Qué necesito para confirmar mi pago?</h3>
        <p>Después de realizar el pago, recibirás un comprobante de transacción o TXID de Binance. Por favor, envíanos este TXID para confirmar tu pago y activar tu promoción.</p>
    </div>

    <div class="faq">
        <h3>¿Cómo sé que mi promoción está activa?</h3>
        <p>Recibirás un correo electrónico de confirmación una vez que tu promoción esté activa. Esto puede tardar hasta 24 horas después de haber recibido tu comprobante de pago.</p>
    </div>

    <div class="faq">
      <h3>¿Qué tipo de comprobante de pago necesito enviar después de realizar el pago en Binance?</h3>
      <p>Una vez realizado el pago en Binance, por favor envíanos una captura de pantalla o un documento que demuestre claramente la transacción realizada, incluyendo el TXID, el monto y la fecha/hora de la transferencia.</p>
  </div>

  <div class="faq">
      <h3>¿Dónde debo enviar el comprobante de pago?</h3>
      <p>Envía el comprobante de tu pago a nuestra dirección de correo electrónico [tu_correo@ejemplo.com] o a través de nuestro formulario de contacto en la página web.</p>
  </div>

  <div class="faq">
      <h3>¿Cómo sabré que mi promoción ha sido activada?</h3>
      <p>Una vez que hayamos verificado tu pago con el comprobante enviado, activaremos tu promoción y te enviaremos una confirmación por correo electrónico. Por favor, permite hasta 24 horas para este proceso.</p>
  </div>

  <div class="faq">
      <h3>¿Qué sucede si hay un problema con mi pago?</h3>
      <p>Si experimentas algún problema o si tu pago no se procesa correctamente, contáctanos inmediatamente con los detalles de la transacción para que podamos ayudarte a resolverlo.</p>
  </div>

</div>
</div>
  
@endsection