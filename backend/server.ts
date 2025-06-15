import express from 'express';
import routes from './src/routes';

const app = express();
const PORT = 3002;

app.use(express.json());
app.use(routes);


app.listen(PORT, () => {
  console.log('Express iniciado na porta: ' + PORT);
});
