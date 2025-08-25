@extends('layouts.app')
@section('titulo')
 - Support
@endsection
@section('contenido')
<style>
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

.faq h3 {
    color: #ddd;
    margin-bottom: 8px;
}

.faq p {
    color: #ddd;
    line-height: 1.5;
}

    .contain {
        max-width: 600px;
        margin: auto;
        padding: 20px;
        background-color: rgb(31, 30, 30);
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    h2 {
        text-align: center;
        color: #ddd;
        margin-bottom: 20px;
    }
    p{
        color: #ddd;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
        color: #333;
    }

    .form-group input[type="text"],
    .form-group input[type="email"],
    .form-group textarea {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        box-sizing: border-box;
    }

    .form-group textarea {
        resize: vertical;
    }

    label{
        color: aliceblue;
    } 
    .form-container .tag {
        background-color: #6c757d; 
    }
  
    .form-container .tag:hover {
        background-color: #5a6268; 
    }
</style>

<div class="contain form-container">
    <h2 data-section="Support" data-value="Support">Soporte</h2>
    <p data-section="Support" data-value="Any">¿Tienes preguntas o necesitas ayuda? Por favor, completa el siguiente formulario y te responderemos lo antes posible.</p>

    <form action="{{ route('info.suportStore') }}" method="POST">
        @csrf

        <div class="form-group">
            <input type="text" data-place="Form" data-val="name" placeholder="Your Name" class="form-control" id="name" name="name" required style="outline:none; background-color: #1b1b1b; color: #fff; border: none; ">
        </div>

        <div class="form-group">
            <input type="email" data-place="Form" data-val="Email" placeholder="Your Email Address" class="form-control" id="email" name="email" required style="outline:none; background-color: #1b1b1b; color: #fff; border: none; ">
        </div>

        <div class="form-group">
            <textarea class="form-control" data-place="Form" data-val="Message" placeholder="Write your message" id="message" name="message" rows="4" required style="outline:none; background-color: #1b1b1b; color: #fff; border: none; "></textarea>
        </div>

        <button type="submit" class="btn tag" style="width: 100%;" data-section="Support" data-value="Send">Enviar Mensaje</button>
    </form>
</div>
<br>
<div class="faq-container" data-section="Support" data-value="QA">
    
    <div class="faq">
        <h3>¿Cómo actualizo mi información de perfil?</h3>
        <p>Para actualizar tu información de perfil, inicia sesión y ve a la sección "Configuración de la cuenta", donde podrás editar tus datos personales.</p>
    </div>

    <div class="faq">
        <h3>¿Qué debo hacer si encuentro un error en la aplicación?</h3>
        <p>Si encuentras un error, por favor envíanos un mensaje a través de nuestro formulario de soporte detallando el problema, y nos encargaremos de solucionarlo lo antes posible.</p>
    </div>

    <div class="faq">
        <h3>¿Qué debo hacer si encuentro un error en la aplicación?</h3>
        <p>Si encuentras un error, por favor envíanos un mensaje a través de nuestro formulario de soporte detallando el problema, y nos encargaremos de solucionarlo lo antes posible.</p>
    </div>

</div>

@endsection