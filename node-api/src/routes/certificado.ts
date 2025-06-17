import { Router } from 'express';
import knex from './../database/knex/index';
import PDFDocument from 'pdfkit';

const routes = Router();

routes.get('/:id', async (req, res) => {
  const alunoId = req.params.id;

  try {
    const aluno = await knex('aluno')
      .join('evento', 'aluno.evento_id', 'evento.id')
      .leftJoin('palestrantes', 'eventos.id', 'palestrante.evento_id')
      .where('alunos.id', alunoId)
      .select(
        'aluno.nome as aluno_nome',
        'aluno.matricula_ra',
        'evento.nome as evento_nome',
        'palestrante.nome as palestrante_nome',
      )
      .first();

    if (!aluno) {
       res.status(404).json({ mensagem: 'Aluno não encontrado!' });
       return
    }

    const doc = new PDFDocument();
    const chunks: Buffer[] = [];

    doc.on('data', (chunk) => chunks.push(chunk));
    doc.on('end', () => {
      const resultado = Buffer.concat(chunks);
      res.setHeader('Content-Type', 'application/pdf');
      res.setHeader('Content-Disposition', 'inline; filename=certificado.pdf');
      res.send(resultado);
    });

    doc.fontSize(25).text('CERTIFICADO DE PARTICIPAÇÃO', { align: 'center' });
    doc.moveDown();
    doc.fontSize(16).text(`Nós da UniAlfa certificamos que ${aluno.aluno_nome} (CPF: ${aluno.matricula_ra})`);
    doc.text(`participou do evento "${aluno.evento_nome}",`);
    doc.text(`com a palestra ministrada por ${aluno.palestrante_nome}.`);
    doc.moveDown();
    doc.fontSize(14).text(`Palestra: ${aluno.palestrante_descr}`, { align: 'justify' });
    doc.moveDown();
    doc.text('Atenciosamente, Direção.', { align: 'right' });

    doc.end();
  } catch (error) {
    console.log(error);
    res.status(500).json({ mensagem: 'Erro ao gerar o certificado' });
  }
});

export default routes;
