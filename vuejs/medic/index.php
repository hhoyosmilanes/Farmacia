<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CRUD con Vue.js, PHP y MySQL</title>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="../../css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../css/materialize.min.css">
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<main id="app" class="container  center">
    <!--section class="row valign-wrapper">
      <div class="col s12 m3">
        <img class="responsive-img" src="https://vuejs.org/images/logo.png" alt="Vue.js">
      </div>
      <div class="col s12 m6">
        <h1>CRUD</h1>
        <h5>(PHP + MySQL)</h5>
      </div>      
    </section>
    <section class="row">
      <div class="col s12">
        <h4>Curso de Vue.js desde cero</h4>
      </div>
    </section-->
    <section class="row valign-wrapper">
      <div class="col s10">
        <h5 class="left">Panel de gestion de Medicamentos</h5>
      </div>
      <div class="col s2">
        <button class="btn-large btn-floating" @click="toggleModal('add')">
          <i class="material-icons">add_circle</i>
        </button>
      </div>
    </section>
    <hr>
    <transition name="fade">
      <p class="u-flexColumnCenter red accent-1 red-text text-darken-4" v-if="errorMessage">
        {{ errorMessage }}
        <i class="material-icons prefix">error</i>
      </p>
      <p class="u-flexColumnCenter green accent-1 green-text text-darken-4" v-if="successMessage">
        {{ successMessage }}
        <i class="material-icons prefix">check_circle</i>
      </p>
    </transition>
    <transition name="fade">
      <table class="striped">
        <tr>
          <th>Codigo</th>
          <th>Nombre</th>
          <th>Telefono</th>
          <th>Editar</th>
          <th>Borrar</th>
          <th>vencimiento</th>
          <th>Laboratorio</th>
        </tr>
        <tr v-for="student in students" :key="student.id">
          <td>{{student.idmedicamnto}}</td>
          <td>{{student.mnombre}}</td>
          <td>{{student.descripcion}}</td>
          <td>{{student.fechaexp}}</td>
          <td>{{student.nombre}}</td>
          <td>
            <button class="btn btn-floating" @click="getStudent('edit', student)">
              <i class="material-icons">edit</i>
              </span>
            </button>
          </td>
          <td>
            <button class="btn btn-floating" @click="getStudent('delete', student)">
              <i class="material-icons">delete</i>
            </button>
          </td>
        </tr>
      </table>
    </transition>
    <transition name="fade">
      <section :class="[ 'ModalWindow', displayAddModal ]" v-if="showAddModal">
        <div class="ModalWindow-container">
          <header class="ModalWindow-heading">
            <div class="row valign-wrapper">
              <div class="col s10">
                <h4 class="left">Agregar Cliente</h4>
              </div>
              <div class="col s2">
                <button class="btn btn-floating right" @click="toggleModal('add')">
                  <i class="material-icons">close</i>
                </button>
              </div>
            </div>
          </header>
          <form class="ModalWindow-content row" @submit.prevent="createStudent">
            <div class="input-field col s12">
              <i class="material-icons prefix">account_circle</i>
              <input name="idmedicamnto" type="text" placeholder="Codigo Medicamento" required>
            </div>
            <div class="input-field col s12">
              <i class="material-icons prefix">account_circle</i>
              <input name="mnombre" type="text" placeholder="Nombre" required>
            </div>
            <div class="input-field col s12">
              <i class="material-icons prefix">email</i>
              <input name="descripcion" type="text" placeholder="Descripcion" required>
            </div>
            <div class="input-field col s12">
              <i class="material-icons prefix">email</i>
              <input name="fechaexp" type="date" placeholder="Fecha de vencimiento" required>
            </div>
            <div class="form-group">
              <select class="form-control" name="idlaboratorio">
                <option>--</option>
                <?php
                  $conn = new mysqli( 'localhost', 'root', '', 'bdfarmacia' );
                  $result = $conn->query( "SELECT * FROM laboratorio" );
                  $students = array();

                  while ( $row = $result->fetch_assoc() ) {
                    array_push( $students, $row );
                  }

                  for ($i=0; $i < count($students); $i++) { 
                    echo "<option value=".$students[$i]['idlaboratorio'].">".$students[$i]['nombre']."</option>";
                  }
                ?>
              </select>
            </div>
            
            <div class="input-field col s12">
              <button class="btn-large btn-floating right" type="submit">
                <i class="material-icons">save</i>
              </button>
            </div>
          </form>
        </div>
      </section>
    </transition>
    <transition name="fade">
      <section :class="['ModalWindow', displayEditModal]" v-if="showEditModal">
        <div class="ModalWindow-container">
          <header class="ModalWindow-heading">
            <div class="row valign-wrapper">
              <div class="col s10">
                <h4 class="left">Editar Estudiante</h4>
              </div>
              <div class="col s2">
                <button class="btn btn-floating right" @click="toggleModal('edit')">
                  <i class="material-icons">close</i>
                </button>
              </div>
            </div>
          </header>
          <form class="ModalWindow-content row" @submit.prevent="updateStudent">
            <div class="input-field col s12">
              <i class="material-icons prefix">account_circle</i>
              <input name="idnew" type="text" placeholder="Codigo Medicamento" required>
            </div>
            <div class="input-field col s12">
              <i class="material-icons prefix">email</i>
              <input v-model="activeStudent.mnombre" name="mnombre" type="text" placeholder="Nombre cliente" required>
            </div>
            <div class="input-field col s12">
              <i class="material-icons prefix">web</i>
              <input v-model="activeStudent.descripcion" name="descripcion" type="text" placeholder="Descripcion" required>
            </div>
            <div class="input-field col s12">
              <i class="material-icons prefix">email</i>
              <input v-model="activeStudent.fechaexp" name="fechaexp" type="date" placeholder="Fecha de vencimiento" required>
            </div>
            <div class="form-group col s12">
              <select class="form-control" name="idlaboratorio" v-model="activeStudent.idlaboratorio">
                <option >{{activeStudent.nombre}}</option>
                <?php
                  for ($i=0; $i < count($students); $i++) { 
                    echo "<option value=".$students[$i]['idlaboratorio'].">".$students[$i]['nombre']."</option>";
                  }
                ?>
              </select>
            </div>

            <div class="input-field col s12">
              <button class="btn-large btn-floating right" type="submit">
                <i class="material-icons">save</i>
              </button>
              <input v-model="activeStudent.idmedicamnto" name="idmedicamnto" type="hidden" required>
            </div>

          </form>
        </div>
      </section>
    </transition>
    <transition name="fade">
      <section :class="['ModalWindow', displayDeleteModal]" v-if="showDeleteModal">
        <div class="ModalWindow-container">
          <header class="ModalWindow-heading">
            <div class="row valign-wrapper">
              <div class="col s10">
                <h4 class="left">Eliminar Estudiante</h4>
              </div>
              <div class="col s2">
                <button class="btn btn-floating right" @click="toggleModal('delete')">
                  <i class="material-icons">close</i>
                </button>
              </div>
            </div>
          </header>
          <form class="ModalWindow-content row" @submit.prevent="deleteStudent">
            <div class="input-field col s12">
              <p class="flow-text center">¿Estás seguro de eliminar al estudiante: <b>{{activeStudent.mnombre}}</b>.</p>
              <input v-model="activeStudent.idmedicamnto" name="idmedicamnto" type="hidden" required>
            </div>
            <div class="input-field col s4 offset-s4">
              <button class="btn-large btn-floating left" type="submit">
                <i class="material-icons">check</i>
              </button>
              <button class="btn-large btn-floating right" type="button" @click="toggleModal('delete')">
                <i class="material-icons">close</i>
              </button>
            </div>
          </form>
        </div>
      </section>
    </transition>
</main>
  <script src="../js/vue.js"></script>
  <script src="../js/axios.min.js"></script>
  <script src="../js/app.js"></script>
</body>
</html>