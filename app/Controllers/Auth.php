<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class Auth extends Controller
{
    public function register()
    {
        helper(['form']);
        return view('auth/register');
    }

    public function save()
    {
        helper(['form']);
        $userModel = new UserModel();

        $data = [
            'nom'      => $this->request->getPost('nom'),
            'pseudo'   => $this->request->getPost('pseudo'),
            'email'    => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'     => 'caissier',
            'profile'  => 'default.png', // photo par défaut
            'statut'   => 'actif',
        ];

        $userModel->insert($data);

        return redirect()->to('/login')->with('success', 'Inscription réussie, vous pouvez vous connecter');
    }

    public function login()
    {
        helper(['form']);
        return view('auth/login');
    }

    public function verify()
    {
        $session = session();
        $userModel = new UserModel();

        $pseudo = $this->request->getPost('pseudo');
        $password = $this->request->getPost('password');

        $user = $userModel->where('pseudo', $pseudo)->first();

        if($user && password_verify($password, $user['password'])){
            $session->set([
                'user_id'   => $user['id'],
                'user_nom'  => $user['nom'],
                'user_profile'  => $user['profile'],
                'user_role' => $user['role'],
                'logged_in' => true
            ]);
            return redirect()->to('/dashboard');
        } else {
            return redirect()->back()->with('error', 'Pseudo ou mot de passe incorrect');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }

    // --------------------------------------
    // Edition utilisateur
    // --------------------------------------
    public function edit($id)
    {
        $userModel = new UserModel();
        $user = $userModel->find($id);

        if(!$user){
            return redirect()->back()->with('error', 'Utilisateur introuvable');
        }

        return view('auth/edit', ['user' => $user]);
    }

    public function update($id)
    {
        $userModel = new UserModel();
        $user = $userModel->find($id);

        if(!$user){
            return redirect()->back()->with('error', 'Utilisateur introuvable');
        }

        $data = [
            'nom'     => $this->request->getPost('nom'),
            'pseudo'  => $this->request->getPost('pseudo'),
            'email'   => $this->request->getPost('email'),
            'role'    => $this->request->getPost('role'),
            'statut'  => $this->request->getPost('statut'),
        ];

        // Mot de passe (optionnel)
        $password = $this->request->getPost('password');
        if(!empty($password)){
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        // Upload photo
        $file = $this->request->getFile('profile');
        if($file && $file->isValid() && !$file->hasMoved()){
            $newName = $file->getRandomName();
            $file->move(ROOTPATH.'public/uploads/', $newName);
            $data['profile'] = $newName;

            // Mettre à jour la session immédiatement
            session()->set('user_profile', $newName);
        }


        $userModel->update($id, $data);

        return redirect()->back()->with('success', 'Profil mis à jour avec succès');
    }
}
