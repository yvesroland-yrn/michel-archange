<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function envoyer(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'telephone' => 'required|string|max:20',
            'sujet' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        Contact::create($validated);

        return back()->with('success', 'Votre message a été envoyé avec succès. Nous vous répondrons dans les plus brefs délais.');
    }

    public function index()
    {
        $contacts = Contact::latest()->paginate(20);
        return view('contacts.index', compact('contacts'));
    }

    public function show(Contact $contact)
    {
        $contact->update(['lu' => true]);
        return view('contacts.show', compact('contact'));
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();
        return back()->with('ok', 'Message supprimé.');
    }

    public function marquerLu(Contact $contact)
    {
        $contact->update(['lu' => !$contact->lu]);
        return back()->with('ok', $contact->lu ? 'Message marqué comme lu.' : 'Message marqué comme non lu.');
    }
}
