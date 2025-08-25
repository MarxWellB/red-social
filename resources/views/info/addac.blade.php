@extends('layouts.app')
@section('titulo')
 - Add accounts
@endsection
@section('contenido')
<style>
    
    .adacount{
        max-width: 600px;
        margin: 0 auto;
        padding: 20px;
    }
    h2 {
        text-align: center;
        margin-bottom: 30px;
        color: #4a4a4a;
    }

    .form-group {
        margin-bottom: 15px;
    }

    label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
        color: #333;
    }

    input[type="text"],
    select {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        box-sizing: border-box;
    }

    .btn-primary {
        width: 100%;
        padding: 10px;
        border: none;
        border-radius: 4px;
        background-color: #007bff;
        color: white;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .btn-primary:hover {
        background-color: #0056b3;
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
    h5,h6,p,h2,label{
      color:#ddd;
    }
  </style>
<div class="form-container">
    <h2 data-section="AInclude" data-value="Include">Añadir Nueva Cuenta</h2>
    <form action="{{ route('info.addstore') }}" method="POST">
        @csrf
        <div class="form-group">
            
        </div>

        <div class="form-group">
            <label for="username" data-section="AInclude" data-value="Username">Nombre de Usuario:</label>
            <input type="text" data-place="Form" data-val="Uname" placeholder="Nombre de Usuario" class="form-control" id="username" name="username" style="outline:none; background-color: #1b1b1b; color: #fff; border: none; " required>
        </div>

        <div class="form-group">
            <label for="platform_link" data-section="AInclude" data-value="Platform">Nombre de la Plataforma:</label>
            <select class="miSelect" name="onlinestore_id" id="package-select" style="outline:none; background-color: #1b1b1b; color: #fff; border: none; width:100%;border-radius:2%;">
                @foreach($onlineStores as $store)
                <option value="{{$store->id}}">{{$store->nombre}}  
                </option>
                    
               
             
            @endforeach
               
              
            </select>
        </div>

        <div class="form-group">
            <label for="profile_link" data-section="AInclude" data-value="PLink">Enlace del Perfil :</label>
            <input type="text" data-place="Form" data-val="PLink" placeholder="Profile Link" class="form-control" id="profile_link" name="profile_link" style="outline:none; background-color: #1b1b1b; color: #fff; border: none; " required>
        </div>

        <button type="submit" class="btn tag" style="width: 100%;" data-section="AInclude" data-value="IAccount">Añadir Cuenta</button>
    </form>
</div>
@if (session('success'))
    <div class="alert alert-success" data-section="Message" data-value="success">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger" data-section="Message" data-value="error">
        {{ session('error') }}
    </div>
@endif

<div class="faq-container" data-section="AInclude" data-value="QA">

    <div class="faq">
        <h3>¿Cómo puedo añadir una nueva cuenta?</h3>
        <p>Para añadir una nueva cuenta, ve al formulario de "Añadir Nueva Cuenta", completa los campos requeridos, y haz clic en el botón "Añadir Cuenta".</p>
    </div>

    <div class="faq">
        <h3>¿Qué información necesito para añadir una cuenta?</h3>
        <p>Necesitarás el nombre de usuario, el enlace de la plataforma donde se encuentra la cuenta, y un enlace opcional al perfil de la cuenta.</p>
    </div>

    <div class="faq">
        <h3>¿Puedo añadir una cuenta que no me pertenece?</h3>
        <p>Sí, puedes añadir cualquier cuenta siempre y cuando tengas los detalles necesarios y la autorización para hacerlo.</p>
    </div>

    <div class="faq">
        <h3>¿Cómo sé que la cuenta ha sido añadida correctamente?</h3>
        <p>Una vez que la cuenta se añade con éxito, recibirás una confirmación en la página o serás redirigido a una página de confirmación.</p>
    </div>
    <div class="faq">
        <h3>¿Hay alguna restricción en el tipo de cuentas que puedo añadir?</h3>
        <p>Sí, solo se pueden añadir cuentas que estén en conformidad con nuestras políticas de uso. No se permiten cuentas que promuevan contenido ilegal o inapropiado.</p>
    </div>
    
    <div class="faq">
        <h3>¿Qué medidas de seguridad se aplican para proteger la información de las cuentas añadidas?</h3>
        <p>Toda la información proporcionada se maneja con estrictas medidas de seguridad. Nos aseguramos de que los datos estén protegidos y solo sean accesibles para operaciones autorizadas.</p>
    </div>
    
    <div class="faq">
        <h3>¿Puedo editar o eliminar una cuenta después de añadirla?</h3>
        <p>Sí, puedes editar o eliminar la información de la cuenta en cualquier momento. Sin embargo, para realizar cambios significativos, es posible que necesites verificaciones adicionales por razones de seguridad.</p>
    </div>
    
    <div class="faq">
        <h3>¿Qué sucede si añado una cuenta con información incorrecta?</h3>
        <p>Si añades una cuenta con información incorrecta, puedes editarla para corregir los detalles. Si no puedes hacerlo tú mismo, ponte en contacto con nosotros para asistencia.</p>
    </div>
    
    <div class="faq">
        <h3>¿Existe algún costo asociado con añadir una cuenta?</h3>
        <p>Normalmente, añadir una cuenta es un proceso gratuito. Si hay algún costo asociado con servicios específicos o promociones, se te notificará claramente durante el proceso.</p>
    </div>
    
    <div class="faq">
        <h3>¿Cómo puedo asegurarme de que la cuenta ha sido añadida correctamente?</h3>
        <p>Después de añadir una cuenta, recibirás una notificación de confirmación. También puedes verificar el estado de la cuenta en tu panel de usuario.</p>
    </div>
    
    <div class="faq">
        <h3>¿Quién puede ver la información de las cuentas que añado?</h3>
        <p>La privacidad y seguridad de tus datos son nuestra prioridad. Solo personal autorizado puede acceder a la información de las cuentas para propósitos de gestión y soporte.</p>
    </div>
    

</div>

@endsection