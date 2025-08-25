@extends('layouts.app')

@section('titulo')
   - Remove
    
@endsection


@section('contenido')
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
    .btn {
        width: 100%;
        padding: 10px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        background-color: #dc3545; 
        color: white;
        transition: background-color 0.3s;
    }

    .btn:hover {
        background-color: #c82333; 
    }
    .faq h3,h2 {
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
<div id="contact-form" class="form-container" style="text-align: center; margin-top: 2rem;margin-bottom:1rem;">
    <h2 data-section="Remove" data-value="Remove">Solicitar Eliminación de Cuenta</h2>
    <form action="{{ route('info.remacdel') }}" method="POST">
        @csrf
        <input type="text" id="username" name="username" data-place="Form" data-val="DUsername" placeholder="Username of the account to be deleted" required style="outline:none; background-color: #1b1b1b; color: #fff; border: none; ">
        <input type="email" name="email" data-place="Form" data-val="Email" placeholder="Your Email Address" required style="outline:none; background-color: #1b1b1b; color: #fff; border: none; "> 
        <textarea name="reason" minlength="10" data-place="Form" data-val="DDescribe" placeholder="Describe the reasons why you want to delete the account" style="outline:none; background-color: #1b1b1b; color: #fff; border: none; " required></textarea>
        <button type="submit" class="btn btn-danger" data-section="Remove" data-value="Delete">Solicitar Eliminación</button>
    </form>
</div>

<div class="faq-container" data-section="Remove" data-value="QA">
    <div class="faq">
        <h3>¿Cómo puedo solicitar la eliminación de mi cuenta?</h3>
        <p>Para solicitar la eliminación de tu cuenta, visita la sección 'Eliminar Cuenta', completa el formulario y envía tu solicitud.</p>
    </div>

    <div class="faq">
        <h3>¿Qué información necesito proporcionar para eliminar mi cuenta?</h3>
        <p>Necesitarás proporcionar tu correo electrónico y nombre de usuario asociado a la cuenta que deseas eliminar.</p>
    </div>

    <div class="faq">
        <h3>¿Cuánto tiempo tarda el proceso de eliminación de una cuenta?</h3>
        <p>El proceso de eliminación puede tardar hasta 48 horas después de recibir tu solicitud.</p>
    </div>

    <div class="faq">
        <h3>¿Puedo recuperar mi cuenta una vez eliminada?</h3>
        <p>No, una vez que una cuenta ha sido eliminada, no se puede recuperar.</p>
    </div>

    <div class="faq">
        <h3>¿Eliminar mi cuenta eliminará también todo mi contenido?</h3>
        <p>Sí, la eliminación de tu cuenta resultará en la eliminación permanente de todo el contenido asociado.</p>
    </div>

    <div class="faq">
        <h3>¿Qué sucede con mi información personal después de la eliminación?</h3>
        <p>Toda tu información personal será permanentemente eliminada de nuestros sistemas conforme a nuestras políticas de privacidad.</p>
    </div>

    <div class="faq">
        <h3>¿Puedo eliminar mi cuenta si tengo suscripciones o servicios activos?</h3>
        <p>Deberás cancelar cualquier suscripción o servicio activo antes de solicitar la eliminación de tu cuenta.</p>
    </div>

    <div class="faq">
        <h3>¿Quién puede solicitar la eliminación de una cuenta?</h3>
        <p>Solo el titular de la cuenta puede solicitar su eliminación. Se requiere verificación para procesar la solicitud.</p>
    </div>

    <div class="faq">
        <h3>¿Recibiré una confirmación de la eliminación de mi cuenta?</h3>
        <p>Sí, recibirás una confirmación por correo electrónico una vez que tu cuenta haya sido eliminada.</p>
    </div>

    <div class="faq">
        <h3>¿Puedo cancelar mi solicitud de eliminación de cuenta?</h3>
        <p>Una vez enviada, no puedes cancelar la solicitud de eliminación. Por favor, asegúrate de que deseas eliminar tu cuenta antes de enviar la solicitud.</p>
    </div>
</div>

<br>
@endsection