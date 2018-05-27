const app = new Vue({
      el: "#app",
      data: {
        showAddModal: false,
        showEditModal: false,
        showDeleteModal: false,
        errorMessage: '',
        successMessage: '',
        students: [],
        activeStudent: {}
      },
      mounted () {
        this.getAllStudents()
      },
      computed: {
        displayAddModal () {
          return ( this.showAddModal ) ? 'u-show' : ''
        },
        displayEditModal () {
          return ( this.showEditModal ) ? 'u-show' : ''
        },
        displayDeleteModal() {
          return ( this.showDeleteModal ) ? 'u-show' : ''
        }
      },
      methods: {
        toggleModal (modal) {
          if ( modal === 'add' ) {
            this.showAddModal = !this.showAddModal
          } else if ( modal === 'edit' ) {
            this.showEditModal = !this.showEditModal
          } if ( modal === 'delete' ) {
            this.showDeleteModal = !this.showDeleteModal
          }
        },
        setMessages (res) {
          if (res.data.error) {
            this.errorMessage = res.data.message
          } else {
            this.successMessage = res.data.message
            this.getAllStudents()
          }

          setTimeout(() => {
            this.errorMessage = false
            this.successMessage = false
          }, 2000)
        },
        getAllStudents () {
          axios.get('./api.php?action=read')
            .then(res => {
              //console.log(res)
              this.setMessages(res)
              this.students = res.data.students
            })
        },
        createStudent (e) {
          axios.post( './api.php?action=create', new FormData( e.target ) )
            .then( res => {
              this.toggleModal('add')
              this.setMessages(res)
            } )
        },
        getStudent (action, student) {
          this.toggleModal(action)
          this.activeStudent = student
        },
        updateStudent (e) {
          axios.post( './api.php?action=update', new FormData( e.target ) )
            .then( res => {
              this.toggleModal('edit')
              this.setMessages(res)
            } )
        },
        deleteStudent (e) {
          axios.post( './api.php?action=delete', new FormData( e.target ) )
            .then( res => {
              this.toggleModal('delete')
              this.setMessages(res)
            } )
        }
      }
    })