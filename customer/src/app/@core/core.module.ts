import { CommonModule } from '@angular/common';
import { ModuleWithProviders, NgModule } from '@angular/core';

const SERVICES = [
];

@NgModule({
  imports: [CommonModule,],
  providers: [...SERVICES],
})
export class CoreModule {
  static forRoot(): ModuleWithProviders<CoreModule> {
    return {
      ngModule: CoreModule,
      providers: [
        ...SERVICES,
      ],
    };
  }
}
