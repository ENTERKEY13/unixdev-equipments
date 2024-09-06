function swalSuccess (title, msg) {
  return Swal.fire(
    {
      title: title || 'สำเร็จ',
      text: msg || '',
      icon: 'success',
      confirmButtonText: 'ตกลง',
    }
  )
}

function swalError (msg) {
  return Swal.fire('เกิดข้อผิดพลาด', msg || '', 'error')
}

function swalLoading (title) {
  Swal.fire({
    text: title === undefined ? 'กำลังบันทึกข้อมูล' : title,
    onBeforeOpen: () => {
      Swal.showLoading()
    },
    showCancelButton: false,
    allowOutsideClick: false,
    allowEscapeKey: false,
  })
}

function swalConfirm (title, onConfirm, options) {
  return Swal.fire(
    Object.assign({
      title: title,
      confirmButtonText: 'ตกลง',
      showCancelButton: true,
      cancelButtonText: 'ยกเลิก',
      reverseButtons: true,
    }, options))
    .then(function (result) {
      result.value && onConfirm && onConfirm()
    })
}

function swalConfirmDelete (title, onConfirm, options) {
  return swalConfirm(title, onConfirm, Object.assign({
    confirmButtonText: 'ลบ',
    confirmButtonColor: '#dd2121',
  }, options))
}

function swalAjaxResult (onSuccess, options) {
  options = options || {}
  return function (res) {
    if (res.success) {
      options.after_confirm !== true && onSuccess && onSuccess(res)
      return swalSuccess(null, res.message).then(function () {
        options.after_confirm === true && onSuccess && onSuccess(res)
      })
    }
    return swalError(res.message)
  }
}
