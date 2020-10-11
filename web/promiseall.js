const numbers = [];
const contents = [];
const s3Data = (i) => {
  contents.push([
    {
      id: i,
    }
  ]);
};

const getCount = (i) => {
  return new Promise((resolve) => {
    return setTimeout(() => resolve(s3Data(i)), 1000);
  });
}


const runAsync = async () => {
  for (let number in numbers) {
    const count = await getCount(number);
  }
  console.log(contents);
}



const recursiveCount = () => {
  if (numbers.length < 5) {
    return new Promise((resolve) => {
      return setTimeout(() => {
        console.log('recursive');
        numbers.push(numbers.length);
        return resolve(recursiveCount());
      }, 1000);
    });
  }
  else {
    runAsync();

  }
}
recursiveCount();

