<?php

use App\Enums\PartnerType;
use App\Models\Partner;
use App\Models\User;

beforeEach(function () {
    $this->admin = User::factory()->admin()->create();
});

/**
 * @return array<string, mixed>
 */
function partnerPayload(array $overrides = []): array
{
    return [
        'name' => 'Test Partner Org',
        'url' => 'https://example.com',
        'role' => ['en' => 'Funds youth ambassador training'],
        'description' => ['en' => 'A short blurb.'],
        'type' => PartnerType::Partner->value,
        'order' => 0,
        'published' => '1',
        ...$overrides,
    ];
}

it('changes a partner\'s type', function (PartnerType $from, PartnerType $to) {
    $partner = Partner::factory()->create(['type' => $from]);

    $this->actingAs($this->admin)
        ->put(route('admin.partners.update', $partner), partnerPayload(['type' => $to->value]))
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('admin.partners.index'));

    expect($partner->refresh()->type)->toBe($to);

    $this->actingAs($this->admin)
        ->get(route('admin.partners.index'))
        ->assertSee("Partner updated — listed under {$to->label()}.");
})->with([
    'partner to advisory council' => [PartnerType::Partner, PartnerType::AdvisoryCouncil],
    'advisory council to collaborator' => [PartnerType::AdvisoryCouncil, PartnerType::Collaborator],
    'collaborator to partner' => [PartnerType::Collaborator, PartnerType::Partner],
]);

it('adds a partner under the chosen type', function () {
    $this->actingAs($this->admin)
        ->post(route('admin.partners.store'), partnerPayload(['type' => PartnerType::Collaborator->value]))
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('admin.partners.index'))
        ->assertSessionHas('success', 'Partner added under Collaborator.');

    expect(Partner::query()->sole()->type)->toBe(PartnerType::Collaborator);
});

it('preselects the partner\'s saved type on the edit form', function () {
    $partner = Partner::factory()->create(['type' => PartnerType::AdvisoryCouncil]);

    $this->actingAs($this->admin)
        ->get(route('admin.partners.edit', $partner))
        ->assertOk()
        ->assertSee('<option value="advisory_council" selected', false);
});

it('moves a partner to its new type section on the public partners page', function () {
    $partner = Partner::factory()->create(['name' => 'Moving Org', 'type' => PartnerType::Partner, 'published' => true]);

    $this->get(route('partners'))->assertSeeInOrder([PartnerType::Partner->label(), 'Moving Org']);

    $this->actingAs($this->admin)
        ->put(route('admin.partners.update', $partner), partnerPayload(['name' => 'Moving Org', 'type' => PartnerType::AdvisoryCouncil->value]));

    $this->get(route('partners'))->assertSeeInOrder([PartnerType::AdvisoryCouncil->label(), 'Moving Org']);
});

it('rejects an unknown partner type', function () {
    $partner = Partner::factory()->create(['type' => PartnerType::Partner]);

    $this->actingAs($this->admin)
        ->put(route('admin.partners.update', $partner), partnerPayload(['type' => 'sponsor']))
        ->assertSessionHasErrors('type');

    expect($partner->refresh()->type)->toBe(PartnerType::Partner);
});
