const express = require('express');
const router = express.Router();
const { Aluno } = require('../models'); // importa o model

// GET /alunos — lista todos os alunos
router.get('/', async (req, res) => {
  try {
    const alunos = await Aluno.findAll();
    res.json(alunos);
  } catch (error) {
    res.status(500).json({ error: error.message });
  }
});

// GET /alunos/:id — busca aluno pelo id
router.get('/:id', async (req, res) => {
  try {
    const aluno = await Aluno.findByPk(req.params.id);
    if (!aluno) return res.status(404).json({ error: 'Aluno não encontrado' });
    res.json(aluno);
  } catch (error) {
    res.status(500).json({ error: error.message });
  }
});

// POST /alunos — cria um novo aluno
router.post('/', async (req, res) => {
  try {
    const novoAluno = await Aluno.create(req.body);
    res.status(201).json(novoAluno);
  } catch (error) {
    res.status(400).json({ error: error.message });
  }
});

// PUT /alunos/:id — atualiza um aluno pelo id
router.put('/:id', async (req, res) => {
  try {
    const aluno = await Aluno.findByPk(req.params.id);
    if (!aluno) return res.status(404).json({ error: 'Aluno não encontrado' });
    await aluno.update(req.body);
    res.json(aluno);
  } catch (error) {
    res.status(400).json({ error: error.message });
  }
});

// DELETE /alunos/:id — remove um aluno pelo id
router.delete('/:id', async (req, res) => {
  try {
    const aluno = await Aluno.findByPk(req.params.id);
    if (!aluno) return res.status(404).json({ error: 'Aluno não encontrado' });
    await aluno.destroy();
    res.status(204).send();
  } catch (error) {
    res.status(500).json({ error: error.message });
  }
});

module.exports = router;
