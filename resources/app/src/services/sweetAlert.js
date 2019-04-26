import swal from 'sweetalert2/dist/sweetalert2.js'
export default {

  informationPopUp (title, text, type) {
    swal.fire({
      title: title,
      text: text,
      type: type,
      customClass: 'sweetalert-sm'
    })
  },

  loading: function () {
    swal.fire({
      title: 'Loading!',
      text: '',
      imageUrl: 'https://mbtskoudsalg.com/images/loading-animated-png-5.gif',
      imageWidth: 50,
      imageHeight: 50,
      imageAlt: 'loading',
      showConfirmButton: false,
      customClass: 'sweetalert-sm'
    })
  },

  deletePopUp: function (action, text) {
    swal.fire({
      title: 'Are you sure?',
      type: 'question',
      text: text,
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes',
      cancelButtonText: 'No',
      closeOnConfirm: false,
      customClass: 'sweetalert-sm'

    })
      .then((result) => {
        if (result.value) {
          action()
          swal.fire({
            title: 'Loading!',
            text: '',
            imageUrl: 'https://mbtskoudsalg.com/images/loading-animated-png-5.gif',
            imageWidth: 50,
            imageHeight: 50,
            imageAlt: 'loading',
            showConfirmButton: false,
            customClass: 'sweetalert-sm'
          })
        } else {
        }
      })
  },

  modifyPopUp: function (action) {
    swal.fire({
      title: 'Are you sure?',
      type: 'question',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes',
      cancelButtonText: 'No',
      closeOnConfirm: false,
      customClass: 'sweetalert-sm'
    })
      .then((result) => {
        if (result.value) {
          action()
          swal.fire({
            title: 'Loading!',
            text: null,
            imageUrl: 'https://mbtskoudsalg.com/images/loading-animated-png-5.gif',
            imageWidth: 50,
            imageHeight: 50,
            imageAlt: 'loading',
            showConfirmButton: false
          })
        } else {
        }
      })
  },

  addPopUp: function (action) {
    swal.fire({
      title: 'Are you sure?',
      text: 'You will not be able to recover this!',
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Confirm',
      closeOnConfirm: false,
      customClass: 'sweetalert-sm'
    })
      .then((result) => {
        if (result.value) {
          action()
          swal.fire({
            title: 'Added!',
            text: 'Row has been added.',
            type: 'success',
            customClass: 'sweetalert-sm'
          })
        } else {
          swal.fire({
            title: 'Loading!',
            text: 'Modal with a custom image.',
            imageUrl: 'https://mbtskoudsalg.com/images/loading-animated-png-5.gif',
            imageWidth: 100,
            imageHeight: 100,
            imageAlt: 'loading'
          })
        }
      })
  },

  removeBuilding: function (action) {
    swal.fire({
      title: 'Are you sure?',
      text: 'You will remove building from access list!',
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Confirm',
      closeOnConfirm: true,
      customClass: 'sweetalert-sm'

    })
  },

  success: function () {
    swal.fire({
      title: 'Success!',
      timer: 1000,
      text: null,
      type: 'success',
      showConfirmButton: false,
      customClass: 'sweetalert-sm'
    })
  },

  failed: function () {
    swal.fire({
      title: 'Error!',
      text: null,
      type: 'error',
      showConfirmButton: false,
      customClass: 'sweetalert-sm'
    })
  },

  failed_: function (text) {
    swal.fire({
      title: 'Error!',
      text: text,
      type: 'error',
      showConfirmButton: false,
      customClass: 'sweetalert-sm'
    })
  }
}
