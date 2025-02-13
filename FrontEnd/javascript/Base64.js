/**
 * Resize a base 64 Image
 * @param {String} base64Str - The base64 string (must include MIME type)
 * @param {Number} MAX_WIDTH - The width of the image in pixels
 * @param {Number} MAX_HEIGHT - The height of the image in pixels
 */
async function reduce_image_file_size(base64Str, MAX_WIDTH = 450, MAX_HEIGHT = 450) {
  let resized_base64 = await new Promise((resolve) => {
      let img = new Image()
      img.src = base64Str
      img.onload = () => {
          let canvas = document.createElement('canvas')
          let width = img.width
          let height = img.height

          if (width > height) {
              if (width > MAX_WIDTH) {
                  height *= MAX_WIDTH / width
                  width = MAX_WIDTH
              }
          } else {
              if (height > MAX_HEIGHT) {
                  width *= MAX_HEIGHT / height
                  height = MAX_HEIGHT
              }
          }
          canvas.width = width
          canvas.height = height
          let ctx = canvas.getContext('2d')
          ctx.drawImage(img, 0, 0, width, height)
          resolve(canvas.toDataURL())
      }
  });
  return resized_base64;
}


async function image_to_base64(file) {
  let result_base64 = await new Promise((resolve) => {
      let fileReader = new FileReader();
      fileReader.onload = (e) => resolve(fileReader.result);
      fileReader.onerror = (error) => {
          console.log(error)
          alert('An Error occurred please try again, File might be corrupt');
      };
      fileReader.readAsDataURL(file);
  });
  return result_base64;
}

async function process_image(file, min_image_size = 300) {
  const res = await image_to_base64(file);
  if (res) {
      const old_size = calc_image_size(res);
      if (old_size > min_image_size) {
          const resized = await reduce_image_file_size(res);
          const new_size = calc_image_size(resized)
          console.log('new_size=> ', new_size, 'KB');
          console.log('old_size=> ', old_size, 'KB');
          document.getElementById("new").src = resized;
          document.getElementById("old").src = res;
          console.log(resized)
          return resized;
      } else {
          console.log(res)
          document.getElementById("old").src = res;
          return res;
      }

  } else {
      console.log('return err')
      return null;
  }
}

function calc_image_size(image) {
  let y = 1;
  if (image.endsWith('==')) {
      y = 2
  }
  const x_size = (image.length * (3 / 4)) - y
  return Math.round(x_size / 1024)
}

// Essa é a função 
async function preview_image() {
  const file = document.getElementById('file');
  const image = await process_image(file.files[0]);
}

export{preview_image}