// app-routing.module.ts

import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { OrderListComponent } from './order-list/order-list.component';
import { PaginationComponent } from './pagination/pagination.component';
import { OrderSearchComponent } from './order-search/order-search.component';

const routes: Routes = [
  { path: '', component: OrderListComponent },
  { path: 'pagination', component: PaginationComponent },
  { path: 'search', component: OrderSearchComponent },
];

@NgModule({
  imports: [RouterModule.forRoot(routes, { useHash: false })],
  exports: [RouterModule]
})
export class AppRoutingModule { }
