@extends('layouts.app')

@section('titulo')
  -Preguntas frecuentes
@endsection

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
.faq h3,h2 {
    color: aliceblue;
    margin-bottom: 5px;
}
.fdo{
  background-color: #141212;;
  border-color: rgb(31, 30, 30);;
}
.collapse {
    display: none; 
}

.collapse.show {
    display: block; 
}
</style>
@section('contenido')

  
<div style="display: flex; justify-content: center; flex-wrap: wrap;">
  <div class="button-containe" style="display: flex; justify-content: center; flex-wrap: wrap; gap: 5px">
      <button class="tag bt selected-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" data-section="FQA" data-value="General">Preguntas Generales</button>
      <button class="tag bt" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" data-section="FQA" data-value="Policy">Preguntas de Políticas de Privacidad</button>
      <button class="tag bt" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree" data-section="FQA" data-value="Accounts">Preguntas sobre Cuentas</button>
      <button class="tag bt" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour" data-section="FQA" data-value="Others">Otras preguntas frecuentes</button>
  </div>
</div>

  
  <script>
  document.addEventListener('DOMContentLoaded', () => {
    const buttons = document.querySelectorAll('.button-containe .bt');
    const accordionItems = document.querySelectorAll('.accordion .card .collapse');

    function toggleAccordion(button, accordionId) {
        const targetAccordion = document.getElementById(accordionId);

        if (button.classList.contains('selected-button')) {
          button.classList.remove('selected-button');
            return;
        }

        buttons.forEach(btn => btn.classList.remove('selected-button'));
        accordionItems.forEach(item => item.classList.remove('show'));

        targetAccordion.classList.add('show');
        button.classList.add('selected-button');
    }

    buttons.forEach(button => {
        button.addEventListener('click', () => {
            const targetId = button.getAttribute('data-bs-target').replace('#', '');
            toggleAccordion(button, targetId);
        });
    });
});

  </script>
  
</div>

<style>
  .button-containe {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 1rem; 
  }

  @media (min-width: 600px) {
      .button-containe {
          flex-direction: row;
      }
  }
.card {
    border: none; 
}

.card-body {
    background-color: transparent; 
    border: none; 
}
.selected-button {
    background-color: grey;
    color: black;
}

</style>
<br>


<div class="accordion" id="accordionExample" style="boder-color:#141212;">
  <div class="card ">
    <div id="collapseOne" class="collapse show fdo " aria-labelledby="headingOne" data-parent="#accordionExample">
      <div class="card-body">
        <div class="faq-container" data-section="FQA" data-value="GQA">
          
      </div>
      </div>
    </div>
  </div>
  <div class="card">
    <div id="collapseTwo" class="collapse fdo" aria-labelledby="headingTwo" data-parent="#accordionExample">
      <div class="card-body">
        <div class="faq-container" data-section="FQA" data-value="PQA">
          
        </div>
      </div>
    </div>
  </div>
  <div class="card">
    <div id="collapseThree" class="collapse fdo" aria-labelledby="headingThree" data-parent="#accordionExample">
      <div class="card-body " data-section="FQA" data-value="AQA">
        
      </div>
    </div>
  </div>
  <div class="card">
    <div id="collapseFour" class="collapse fdo" aria-labelledby="headingFour" data-parent="#accordionExample">
      <div class="card-body " data-section="FQA" data-value="OQA">
        
      </div>
    </div>
  </div>
</div>


<br>


@endsection