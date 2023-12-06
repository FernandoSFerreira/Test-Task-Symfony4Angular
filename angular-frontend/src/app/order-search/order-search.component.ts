// order-search.component.ts

import { Component } from '@angular/core';
import { OrderService } from '../order.service';

@Component({
  selector: 'app-order-search',
  templateUrl: './order-search.component.html',
  styleUrls: ['./order-search.component.css']
})
export class OrderSearchComponent {
  searchTerm: string = '';
  searchBy: string = '';
  errorMessage: string = '';
  searchedOrders: any[] = [];

  constructor(private orderService: OrderService) {}

  search() {
    this.orderService.searchOrders(this.searchTerm, this.searchBy).subscribe(
      data => {
        // Logic for handling search results
        this.searchedOrders = data; // Store search results
      },
      error => {
        console.error('Error searching orders', error);
        this.errorMessage = 'Failed to search orders. Please try again later.';
      }
    );
  }
}
